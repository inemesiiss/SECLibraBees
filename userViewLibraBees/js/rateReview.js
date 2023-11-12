const forms = document.querySelectorAll('.rate form');

forms.forEach(form => {
  const button = form.querySelector('.buttonRate input');

  form.addEventListener('submit', e => {
    e.preventDefault();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'rateReturnBook.php', true);

    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;

          if (data.includes('success')) {
            alert('Review Successfully Submitted!');
            console.log(data);
            button.disabled = true;
            form.parentElement.style.display = 'none'; // hide the form's parent element
            const successMessage = document.createElement('p');
            successMessage.innerText = 'Review Successfully Submitted!';
            form.parentElement.appendChild(successMessage); // add the success message to the form's parent element
          } else {

          }
        }
      }
    };

    let formData = new FormData(form);
    xhr.send(formData);
  });
});
