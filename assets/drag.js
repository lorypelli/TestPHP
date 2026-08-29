const draggable = document.querySelector('[data-draggable="true"]');
const not_draggable = document.querySelector('[data-draggable="false"]');
let start_x = 0;
let start_y = 0;
let offset_x = 0;
let offset_y = 0;
let is_dragging = false;
draggable.addEventListener('pointerdown', (e) => {
    if (not_draggable.contains(e.target)) {
        return;
    }
    is_dragging = true;
    start_x = e.clientX - offset_x;
    start_y = e.clientY - offset_y;
});
document.addEventListener('pointermove', (e) => {
    if (!is_dragging) {
        return;
    }
    let x = e.clientX - start_x;
    let y = e.clientY - start_y;
    const parent_rect = draggable.parentElement.getBoundingClientRect();
    const rect = draggable.getBoundingClientRect();
    const new_left = rect.left - offset_x + x;
    const new_top = rect.top - offset_y + y;
    const new_right = new_left + rect.width;
    const new_bottom = new_top + rect.height;
    if (new_left < parent_rect.left) {
        x += parent_rect.left - new_left;
    }
    if (new_right > parent_rect.right) {
        x -= new_right - parent_rect.right;
    }
    if (new_top < parent_rect.top) {
        y += parent_rect.top - new_top;
    }
    if (new_bottom > parent_rect.bottom) {
        y -= new_bottom - parent_rect.bottom;
    }
    draggable.style.translate = `${x}px ${y}px`;
    offset_x = x;
    offset_y = y;
});
document.addEventListener('pointerup', () => {
    is_dragging = false;
});
