const dictionary = {
    /**
     * The text used before any files are dropped.
     */
    dictDefaultMessage: "Перетащите файлы, чтобы загрузить их",

    /**
     * The text that replaces the default message text it the browser is not supported.
     */
    dictFallbackMessage: "Ваш браузер не поддерживает перетаскивание файлов.",

    /**
     * The text that will be added before the fallback form.
     * If you provide a  fallback element yourself, or if this option is `null` this will
     * be ignored.
     */
    dictFallbackText: "Используйте форму ниже, чтобы загрузить файлы обычным способом.",

    /**
     * If the filesize is too big.
     * `{{filesize}}` and `{{maxFilesize}}` will be replaced with the respective configuration values.
     */
    dictFileTooBig: "Файл слишком большой ({{filesize}}MB). Максимальный размер: {{maxFilesize}}MB.",

    /**
     * If the file doesn't match the file type.
     */
    dictInvalidFileType: "Вы не можете загружать файлы этого типа.",

    /**
     * If the server response was invalid.
     * `{{statusCode}}` will be replaced with the servers status code.
     */
    dictResponseError: "Сервер ответил кодом {{statusCode}}.",

    /**
     * If `addRemoveLinks` is true, the text to be used for the cancel upload link.
     */
    dictCancelUpload: "Отменить загрузку",

    /**
     * The text that is displayed if an upload was manually canceled
     */
    dictUploadCanceled: "Загрузка отменена.",

    /**
     * If `addRemoveLinks` is true, the text to be used for confirmation when cancelling upload.
     */
    dictCancelUploadConfirmation: "Вы уверены, что хотите отменить эту загрузку?",

    /**
     * If `addRemoveLinks` is true, the text to be used to remove a file.
     */
    dictRemoveFile: "Удалить файл",

    /**
     * If this is not null, then the user will be prompted before removing a file.
     */
    dictRemoveFileConfirmation: null,

    /**
     * Displayed if `maxFiles` is st and exceeded.
     * The string `{{maxFiles}}` will be replaced by the configuration value.
     */
    dictMaxFilesExceeded: "Вы не можете загрузить больше файлов.",

    /**
     * Allows you to translate the different units. Starting with `tb` for terabytes and going down to
     * `b` for bytes.
     */
    dictFileSizeUnits: {
        tb: "TB",
        gb: "GB",
        mb: "MB",
        kb: "KB",
        b: "b"
    },
}

export default dictionary;
