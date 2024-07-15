document.addEventListener("DOMContentLoaded", () => {
    const entryForm = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entryImage = document.getElementById("entry_image");
    const entriesContainer = document.getElementById("entries_container");
    const sortNewest = document.getElementById("sort_newest");
    const sortOldest = document.getElementById("sort_oldest");

    entryForm.addEventListener("submit", async function(event) {
        event.preventDefault();
        const entry = entryInput.value;
        const file = entryImage.files[0];
        const formData = new FormData();
        formData.append('entry', entry);
        if (file) {
            formData.append('entry_image', file);
        }

        try {
            const response = await fetch('diary_entries.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.status === 'success') {
                loadEntries();
                entryInput.value = '';
                entryImage.value = '';
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });

    const loadEntries = async () => {
        try {
            const response = await fetch('diary_entries.php');
            const data = await response.json();
            displayEntries(data);
        } catch (error) {
            console.error("Error:", error);
        }
    };

    const editEntry = async (entryId) => {
        const newContent = prompt("Edit your entry:");
        if (newContent !== null) {
            try {
                const response = await fetch('diary_entries.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `entry_id=${entryId}&entry=${encodeURIComponent(newContent)}`
                });
                const data = await response.json();
                if (data.status === 'success') {
                    loadEntries();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    };

    const deleteEntry = async (entryId) => {
        if (confirm("Are you sure you want to delete this entry?")) {
            try {
                const response = await fetch('diary_entries.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `entry_id=${entryId}`
                });
                const data = await response.json();
                if (data.status === 'success') {
                    loadEntries();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    };

    sortNewest.addEventListener('click', () => {
        fetchEntries('newest');
    });

    sortOldest.addEventListener('click', () => {
        fetchEntries('oldest');
    });

    const fetchEntries = async (sortOrder) => {
        try {
            const response = await fetch(`diary_entries.php?sort=${sortOrder}`);
            const data = await response.json();
            displayEntries(data);
        } catch (error) {
            console.error("Error:", error);
        }
    };

    const displayEntries = (entries) => {
        entriesContainer.innerHTML = '';
        entries.forEach(entry => {
            const entryDiv = document.createElement('div');
            entryDiv.classList.add('entry');
            entryDiv.innerHTML = `
                <p>${entry.entry}</p>
                ${entry.entry_image ? `<img src="${entry.entry_image}" alt="Entry Image">` : ''}
                <span class="timestamp">${entry.entry_date}</span>
                <button class="edit-button" data-id="${entry.entry_id}">Edit</button>
                <button class="delete-button" data-id="${entry.entry_id}">Delete</button>
            `;
            entriesContainer.appendChild(entryDiv);
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', () => editEntry(button.getAttribute('data-id')));
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', () => deleteEntry(button.getAttribute('data-id')));
        });
    };

    loadEntries();
});