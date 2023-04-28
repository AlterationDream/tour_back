<option value="0" @if(isset($selected) && $selected == 0) selected @endif>Первая</option>
@foreach($categories as $category)
    <option value="{{ $category->order }}" @if(isset($selected) && $selected == $category->order) selected @endif>{{ $category->name }}</option>
@endforeach
