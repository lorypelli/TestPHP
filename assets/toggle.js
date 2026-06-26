/// <reference path="svg.ts" />
const passwords = document.querySelectorAll('div[data-pwd]');
const svgs = document.querySelectorAll('div[data-svg]');
let visible = false;
passwords.forEach((pwd, i) => {
    if (svgs[i].innerHTML.trim() == '') {
        svgs[i].innerHTML = disabledcapslock;
    }
    const input = pwd.querySelector('input');
    input.addEventListener('keydown', (e) => {
        svgs[i].innerHTML = e.getModifierState('CapsLock')
            ? capslock
            : disabledcapslock;
    });
    const button = pwd.querySelector('button');
    if (button.innerHTML.trim() == '') {
        button.innerHTML = show;
    }
    button.addEventListener('click', () => {
        visible = !visible;
        if (visible) {
            svgs[i].style.display = 'none';
            input.style.paddingLeft = 'calc(var(--spacing) * 1)';
        } else {
            svgs[i].removeAttribute('style');
            input.removeAttribute('style');
        }
        input.type = visible ? 'text' : 'password';
        button.innerHTML = visible ? hide : show;
    });
});
