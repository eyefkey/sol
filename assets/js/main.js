// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
function openModal() {
    var modal = document.getElementById('addEmployeeModal');
    modal.style.display = "block";
}
function closeModal() {
    var modal = document.getElementById('addEmployeeModal');
    modal.style.display = "none";
}
function openEdit() {
    var modal = document.getElementById('editEmployeeModal');
    modal.style.display = "block";
}
function closeEdit() {
    var modal = document.getElementById('editEmployeeModal');
    modal.style.display = "none";
}
function openDelete() {
    var modal = document.getElementById('deleteEmployeeModal');
    modal.style.display = "block";
}
function closeDelete() {
    var modal = document.getElementById('deleteEmployeeModal');
    modal.style.display = "none";
}
function openModalstudent() {
  var modal = document.getElementById('addStudentModal');
  modal.style.display = "block";
}

function closeMOD() {
  var modal = document.getElementById('addStudentModal');
  modal.style.display = "none";
}

document.querySelectorAll('.close').forEach(function(closeButton) {
  closeButton.addEventListener('click', function() {
    this.closest('.modal').style.display = 'none';
  });
});

// Add event listener to close modal when clicking outside the modal content
document.querySelectorAll('.modal').forEach(function(modal) {
  modal.addEventListener('click', function(event) {
    if (event.target === this) {
      this.style.display = 'none';
    }
  });
});

function openEditstudent() {
  var modal = document.getElementById('editStudentModal');
  modal.style.display = "block";
}
function closeEDIT() {
  var modal = document.getElementById('editStudentModal');
  modal.style.display = "none";
}
function openDeletestudent() {
  var modal = document.getElementById('deleteStudentModal');
  modal.style.display = "block";
}
function closeDelete() {
  var modal = document.getElementById('deleteStudentModal');
  modal.style.display = "none";
}
function openImportModal() {
  var modal = document.getElementById('importModal');
  modal.style.display = "block";
}
function closeImportModal() {
  var modal = document.getElementById('importModal');
  modal.style.display = "none";
}

function openModalSubject(){
  var modal = document.getElementById('addSubjectModal');
  modal.style.display = "block";
}
function closeModal() {
  var modal = document.getElementById("addSubjectModal");
  modal.style.display = "none";
}
function openEditSubject() {
  var modal = document.getElementById("editSubjectModal");
  modal.style.display = "block";
}
function closeEdit() {
  var modal = document.getElementById("editSubjectModal");
  modal.style.display = "none";
}
function openDeleteSubject() {
  var modal = document.getElementById("deleteSubjectModal");
  modal.style.display = "block";
}
function closeDelete(){
  var modal = document.getElementById("deleteSubjectModal");
  modal.style.display = "none";
}
function openAssignSubject(){
  var modal = document.getElementById("assignSubjectModal");
  modal.style.display = "block";
}
function closeAssign(){
  var modal = document.getElementById("assignSubjectModal");
  modal.style.display = "none";
}
