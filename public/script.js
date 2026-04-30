// Function to show selected section
function showSection(sectionID) {
    // Hide all sections
    const sections = document.querySelectorAll('.content, .homecontent');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected section
    const activeSection = document.getElementById(sectionID);
    if (activeSection) {
        activeSection.style.display = 'block';
    }

    // Update active state for navbar buttons
    const buttons = document.querySelectorAll('.navbarbuttons');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        // If the button's onclick contains the sectionID, mark it active
        if (btn.getAttribute('onclick').includes(`'${sectionID}'`)) {
            btn.classList.add('active');
        }
    });
}

// Mouse event on logo to hide all sections and show home
function hideSections() {
    const sections = document.querySelectorAll('.content');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    const homesection = document.getElementById('home');
    if (homesection) {
        homesection.style.display = 'block';
    }

    // Remove active class from all buttons
    const buttons = document.querySelectorAll('.navbarbuttons');
    buttons.forEach(btn => btn.classList.remove('active'));
}

// Clear Fields function for Create section
function clearFields() {
    const inputs = document.querySelectorAll('#create input');
    inputs.forEach(input => {
        input.value = '';
    });
}

// Clear Fields function for Update section
function clearUpdateFields() {
    const inputs = document.querySelectorAll('#update input');
    inputs.forEach(input => {
        input.value = '';
    });
    document.getElementById('updateForm').style.display = 'none';
}

// Clear Fields function for Delete section
function clearDeleteFields() {
    const inputs = document.querySelectorAll('#deleteForm input');
    inputs.forEach(input => {
        input.value = '';
    });
}

// Fetch student by ID for update section
function fetchStudent() {
    const id = document.getElementById('update_id').value;
    if (!id) {
        customAlert('Please enter a Student ID', 'Input Required');
        return;
    }

    // Using the ID as a loading state indicator could be nice, but keeping it simple for now
    fetch('includes/fetch_student.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_surname').value = data.surname;
                document.getElementById('edit_middlename').value = data.middlename || '';
                document.getElementById('edit_address').value = data.address || '';
                document.getElementById('edit_contact').value = data.contact_number || '';
                
                const form = document.getElementById('updateForm');
                form.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth' });
            } else {
                customAlert('Student not found!', 'Search Failed');
                document.getElementById('updateForm').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            customAlert('Error fetching student data.', 'Connection Error');
        });
}

// Toast handling on window load
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    
    if (status) {
        let toastId = '';
        if (status === 'success') toastId = 'success-toast';
        else if (status === 'updated') toastId = 'update-toast';
        else if (status === 'deleted') toastId = 'delete-toast';

        if (toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('toast-hidden');
                toast.style.opacity = '1';
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.classList.add('toast-hidden'), 500);
                }, 4000);
            }
        }

        // Clean up URL without refreshing
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

// Custom delete modal functions
function openDeleteModal() {
    var studentId = document.getElementById('delete_id').value;
    if (!studentId) {
        customAlert('Please enter a Student ID to delete.', 'Input Required');
        return;
    }
    
    // Check if the student ID exists
    fetch('includes/fetch_student.php?id=' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                // ID exists, show the confirmation modal
                document.getElementById('deleteModal').classList.add('active');
                
                // Focus the delete button so pressing Enter triggers it
                setTimeout(() => {
                    document.getElementById('confirmDeleteBtn').focus();
                }, 100);
            } else {
                // ID does not exist
                customAlert('Invalid ID number', 'Search Failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            customAlert('Error verifying student ID.', 'Connection Error');
        });
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

function confirmDelete() {
    document.getElementById('deleteForm').submit();
}

// Custom Alert modal functions
function customAlert(message, title = 'Notice') {
    let iconType = 'warning';
    if (title === 'Connection Error' || title === 'Search Failed') {
        iconType = 'error';
    } else if (title === 'Input Required') {
        iconType = 'info';
    }
    
    Swal.fire({
        title: title,
        text: message,
        icon: iconType,
        confirmButtonColor: '#1e3a8a',
        confirmButtonText: 'Okay'
    });
}
