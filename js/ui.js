const SCROLL_KEY = 'beach_torneio_scroll';

function salvarPosicaoRolagem() {
    const posicao = window.scrollY || window.pageYOffset || 0;
    sessionStorage.setItem(SCROLL_KEY, String(posicao));
}

function restaurarPosicaoRolagem() {
    const valor = sessionStorage.getItem(SCROLL_KEY);
    if (valor !== null) {
        const posicao = Number(valor);
        if (!isNaN(posicao) && posicao > 0) {
            window.scrollTo(0, posicao);
        }
    }
}

document.addEventListener('click', (event) => {
    const alvo = event.target.closest('a, button, input[type="submit"]');
    if (alvo) {
        salvarPosicaoRolagem();
    }
});

document.addEventListener('submit', () => {
    salvarPosicaoRolagem();
});

window.addEventListener('beforeunload', salvarPosicaoRolagem);
window.addEventListener('load', restaurarPosicaoRolagem);
window.addEventListener('pageshow', () => {
    setTimeout(restaurarPosicaoRolagem, 50);
});