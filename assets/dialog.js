const dialog = document.querySelector('dialog');
const form = dialog.querySelector('form');
const div = document.querySelector('div[data-dialog]');
const todo_id = document.createElement('input');
dialog.addEventListener('keydown', (e) => {
    if (e.key == 'Escape') {
        e.preventDefault();
        closeDialog();
    }
});

function openDialog(id = '') {
    const name = form.querySelector("input[name='name']");
    const description = form.querySelector("textarea[name='description']");
    const is_done = form.querySelector("input[name='is_done']");
    if (id.trim() != '') {
        form.action = '/api/edit';
        const todo = document.querySelector(`form[data-todo='${id}']`);
        if (todo) {
            todo_id.name = 'id';
            todo_id.type = 'hidden';
            todo_id.readOnly = true;
            todo_id.autocomplete = 'off';
            todo_id.value = id;
            form.appendChild(todo_id);
            const todo_name = todo
                .querySelector("input[name='name']")
                .getAttribute('value');
            const todo_description = todo
                .querySelector("input[name='description']")
                .getAttribute('value');
            const todo_is_done = todo
                .querySelector("input[name='is_done']")
                .hasAttribute('checked');
            if (todo_name) {
                name.value = todo_name;
            } else {
                name.value = '';
            }
            if (todo_description) {
                description.textContent = todo_description;
            } else {
                description.textContent = '';
            }
            is_done.checked = todo_is_done;
            history.pushState(null, '', `/${id}`);
        }
    } else {
        name.value = '';
        description.textContent = '';
        is_done.checked = false;
        form.action = '/api/add';
    }
    div.dataset.open = '';
    dialog.showModal();
}

function closeDialog() {
    const abortController = new AbortController();
    div.removeAttribute('data-open');
    form.removeAttribute('action');
    if (form.contains(todo_id)) {
        form.removeChild(todo_id);
        history.replaceState(null, '', '/');
    }
    document.addEventListener(
        'animationend',
        () => {
            dialog.close();
            abortController.abort();
        },
        { signal: abortController.signal },
    );
}
