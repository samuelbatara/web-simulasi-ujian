async function saveAnswer(numberOfQuestions, questionNumber, answer) {

  request = {
    "questionNumber": questionNumber,
    "answer": answer
  };

  result = null;
  await $.ajax({
    url: '/simpan-jawaban/' + questionNumber + '/' + answer,
    method: 'GET',
    success: function(response) {
      console.log("Successfully to save answer for questionNumber=" 
        + questionNumber 
        + ", answer=" + answer);
      result = response;
    },
    error: function(response) {
      console.log("Failed to request to '/simpan-data' with questionNumber=" 
        + questionNumber 
        + ", answer=" + answer);
    }
  });

  // Change button color to btn-info
  changeButtonColor(questionNumber);

  // Activate submit button if all questions is already answered
  console.log("Number of questions that have answered: ", result);
  if (numberOfQuestions == result) {
    activatedSubmitButton('form.submit');
  }
  return result;
}

function changeButtonColor(page) {
  button = document.getElementById('question.' + page);
  console.log("page " + page);
  console.log(button.getAttribute('class'));
  button.setAttribute('class', 'btn btn-info');
}

function activatedSubmitButton(id) {
  const content = "<button type='submit' class='btn btn-primary'>Selesai</button>";

  element = document.getElementById(id);
  element.innerHTML = content;
}
