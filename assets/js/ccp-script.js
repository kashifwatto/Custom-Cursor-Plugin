document.addEventListener('DOMContentLoaded', function () {

    if (!CCP_DATA.image) return;

    const cursor = document.createElement('img');
    cursor.id = 'ccp-cursor';
    cursor.src = CCP_DATA.image;
    cursor.style.width = CCP_DATA.size + 'px';
    cursor.style.height = CCP_DATA.size + 'px';
    cursor.style.position = 'fixed';
    cursor.style.pointerEvents = 'none';
    cursor.style.zIndex = '999999';
    cursor.style.willChange = 'transform';

    document.body.appendChild(cursor);

    let mouseX = 0;
    let mouseY = 0;
    let rafId = null;

    document.addEventListener('mousemove', function (e) {
        mouseX = e.clientX;
        mouseY = e.clientY;

        if (!rafId) {
            rafId = requestAnimationFrame(updateCursor);
        }
    });

    function updateCursor() {
        cursor.style.transform =
            'translate3d(' + mouseX + 'px,' + mouseY + 'px,0) translate(-50%, -50%)';
        rafId = null;
    }

});
