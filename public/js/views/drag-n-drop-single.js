function dragNdrop(event) {
    let preview = document.getElementById("preview");
    preview.innerHTML = '';
    /*for (image of event.target.files) {
        let fileName = URL.createObjectURL(image);
        let previewImg = document.createElement("div");
        previewImg.style.background = 'url(' + fileName + ')';
        preview.appendChild(previewImg);
    }*/
    let fileName = URL.createObjectURL(event.target.files[0]);
    let previewImg = document.createElement("img");
    previewImg.setAttribute('src', fileName);
    preview.appendChild(previewImg);
}
function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}
function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}
