const { it, expect, document } = global;
document.head.innerHTML = '<meta name="csrf-token" content="token">';
document.body.innerHTML = '<div id="canvas"></div>';

require('../app');

it.skip('loads Popper', () => {
    expect(window).toHaveProperty('Popper');
});

it.skip('loads Vue', () => {
    expect(window).toHaveProperty('Vue');
});
