@extends('statamic::layout')
@section('title', $title)

@section('content')
    <div id="image-preview-wrapper">
        <img src="{{ $preview }}">
    </div>
    <publish-form
        title="{{ $title }}"
        action="{{ $action }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
        @saved="reloadPreview"
    ></publish-form>
    <script>
    function reloadPreview() {
        fetch("/cp/og-generator/preview", {
            method: "GET",
        }).then(response => response.json()).then((data) => {
            document.getElementById("image-preview-wrapper").innerHTML = `<img src="${data.preview}">`;
        });
    }
    </script>
@endsection

<style>

#image-preview-wrapper {
    padding: 90px;
}

</style>
