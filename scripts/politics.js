function copyCode() {
    const codeBlock = document.getElementById('codeBlock');
    const codeText = codeBlock.innerText;

    const tempTextarea = document.createElement('textarea');
    tempTextarea.value = codeText;
    document.body.appendChild(tempTextarea);
    tempTextarea.select();
    document.execCommand('copy');
    document.body.removeChild(tempTextarea);

    const codeContainer = document.getElementById('codeContainer');
    codeContainer.classList.add('copied');

    const copyButton = codeContainer.querySelector('.copy-button');
    copyButton.textContent = 'Скопировано';

    setTimeout(() => {
        codeContainer.classList.remove('copied');
        copyButton.textContent = 'Скопировать';
    }, 3000);
}
