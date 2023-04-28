function dragNdrop(event) {
    let preview = document.getElementById("preview");
    let orderInput = $('#image_order')
    let initialOrder = []
    preview.innerHTML = '';
    let count = 0;
    for (image of event.target.files) {
        let fileName = URL.createObjectURL(image);
        let imgContainer = document.createElement('div')
        imgContainer.classList.add('col-md-4')
        imgContainer.classList.add('ui-state-default')
        imgContainer.setAttribute('initial-order', ++count)
        initialOrder.push(count)
        let previewImg = document.createElement("img");
        previewImg.setAttribute('src', fileName);
        imgContainer.appendChild(previewImg)
        preview.appendChild(imgContainer);
    }
    orderInput.val(initialOrder.toString())
}
function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}
function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}
