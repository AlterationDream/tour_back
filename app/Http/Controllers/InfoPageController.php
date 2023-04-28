<?php

namespace App\Http\Controllers;

use App\Models\InfoPage;
use App\Traits\ImageStorageTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InfoPageController extends Controller
{
    use ImageStorageTrait;
    static string $imagesFolder = 'info-pages-images';

    public function aboutUs() {
        $pageId = 1;
        $pageName = 'О нас';
        $blockFormats = $this->blockFormats();
        $page = InfoPage::find($pageId);
        return view('info-pages.index', compact('page', 'blockFormats', 'pageId', 'pageName'));
    }
    public function vip() {
        $pageId = 2;
        $pageName = 'VIP';
        $blockFormats = $this->blockFormats();
        $page = InfoPage::find($pageId);
        return view('info-pages.index', compact('page', 'blockFormats', 'pageId', 'pageName'));
    }

    public function update(Request $request) {
        $json = json_decode($request->json_eval, false, 512, JSON_UNESCAPED_UNICODE);
        if (is_null($json) || !$request->has('id')) {
            return back()->withErrors('Структура страницы нарушена');
        }
        $page = InfoPage::find($request->id);
        $oldContent = json_decode($page->content, false, 512, JSON_UNESCAPED_UNICODE);
        if ($oldContent != '[]') {
            $this->findImages($oldContent, $this, true);
        }
        $this->findImages($json, $this);

        $page->content = json_encode($json, JSON_UNESCAPED_UNICODE);
        $page->save();
        return back()->with('success', 'Страница успешно обновлена!');
    }

    /**
     * Search for images in a JSON array. Deletes images in the old array, stores them for the new one.
     *
     * @param array $arr - JSON array to parse for images
     * @param InfoPageController $that - Controller context to call image trait.
     * @param boolean $old - If the array is an old collection containing image paths.
     * @param string $prop - Property containing the name of the content element type.
     * @param string $val - Property name of the content element type.
     * @param string $contName - Name of the property of the elements' contents.
     */
    public static function findImages(array &$arr, InfoPageController $that, bool $old = false, string $prop = 'type', string $val = 'bg', string $contName = 'content') {
        foreach ($arr as $obj) {
            if (property_exists($obj, $prop) && $obj->{$prop} == $val) {
                if ($old && substr($obj->{$contName},0, 10) != 'data:image')
                {
                    $that->deleteImage($obj->{$contName}, self::$imagesFolder);
                }
                elseif (substr($obj->{$contName},0, 10) == 'data:image')
                {
                    $obj->{$contName} = $that->storeB64Image($obj->{$contName}, self::$imagesFolder);
                }
            }
        }

        foreach ($arr as $obj) {
            if (property_exists($obj, $contName) && is_array($obj->{$contName})) {
                InfoPageController::findImages($obj->{$contName}, $that, $old, $prop, $val, $contName);
            }
        }
    }

    // region Block Formats
    private function blockFormats() {
        return [
            'sections' => [
                'imageBGSection' => [
                    'name' => 'Секция с фоном-изображением',
                    'type' => 'setContent',
                    'content' => [
                        'bg' => [
                            'inputName' => 'Изображение',
                            'type' => 'image'
                        ],
                        'title' => [
                            'inputName' => 'Заголовок',
                            'type' => 'string'
                        ],
                        'description' => [
                            'inputName' => 'Текст',
                            'type' => 'text',
                        ],
                    ],
                ],
                'whiteSection' => [
                    'name' => 'Секция с белым фоном',
                    'type' => 'variableContent',
                    'content' => ['heading', 'text', 'video', 'button', 'ul'],
                ],
                'blackSection' => [
                    'name' => 'Секция с чёрным фоном',
                    'type' => 'variableContent',
                    'content' => ['heading', 'text', 'video', 'button', 'ul'],
                ],
                'blueSection' => [
                    'name' => 'Секция с синим фоном',
                    'type' => 'variableContent',
                    'content' => ['heading', 'text', 'ul'],
                ],
                'howWeWorkSection' => [
                    'name' => 'Как мы работаем',
                    'type' => 'setContent',
                    'content' => [
                        'points' => [
                            'inputName' => 'Шаги',
                            'type' => 'array',
                            'format' => [
                                'title' => [
                                    'inputName' => 'Заголовок',
                                    'type' => 'string'
                                ],
                                'description' => [
                                    'inputName' => 'Текст',
                                    'type' => 'text',
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'contents' => [
                'heading' => [
                    'name' => 'Заголовок',
                    'inputName' => 'Текст заголовка',
                    'type' => 'string',
                ],
                'text' => [
                    'name' => 'Текст',
                    'inputName' => 'Текст',
                    'type' => 'text',
                ],
                'video' => [
                    'name' => 'Видео',
                    'inputName' => 'ID Видео YouTube',
                    'type' => 'video',
                ],
                'image' => [
                    'name' => 'Изображение',
                    'inputName' => 'Изображение',
                    'type' => 'image',
                ],
                'button' => [
                    'name' => 'Кнопка',
                    'inputName' => 'Текст кнопки',
                    'type' => 'button',
                    'actions' => [
                        'contact' => 'Связаться с менеджером'
                    ]
                ],
                'ul' => [
                    'name' => 'Список',
                    'inputName' => 'Строки',
                    'type' => 'array',
                    'format' => [
                        'line' => [
                            'inputName' => 'Строка',
                            'type' => 'string',
                        ]
                    ]
                ]
            ],
        ];
    }
    // endregion

    public function getAboutPage() : JsonResponse
    {
        $page = InfoPage::find(1);
        return response()->json(json_decode($page->content, false, 512, JSON_UNESCAPED_UNICODE));
    }

    public function getVIPPage() {
        $page = InfoPage::find(2);
        return response()->json($page->content);
    }
}
