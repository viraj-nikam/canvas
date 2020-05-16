const { it, expect, document } = global;
document.head.innerHTML = '<meta name="csrf-token" content="token">';
document.body.innerHTML = '<div id="canvas"></div>';

require('../app');

it('loads Popper', () => {
    expect(window).toHaveProperty('Popper');
});

it('loads Vue', () => {
    expect(window).toHaveProperty('Vue');
});
