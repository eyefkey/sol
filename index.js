function showModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "block";
  var errorMessage =
    "<?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : ''; ?>";
  document.getElementById("error-message").innerText = errorMessage;
}

function closeModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
}

// Close the modal if the user clicks outside of it
window.onclick = function (event) {
  var modal = document.getElementById("myModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
