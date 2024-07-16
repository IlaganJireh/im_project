document.addEventListener('DOMContentLoaded', function () {
    // Mood Tracker Functionality
    const moodIcons = document.querySelectorAll('.mood-icon');
    const motivationalQuote = document.querySelector('.motivational-quote');
    const moodEntriesContainer = document.getElementById('mood_entries');
    let selectedMood = null;

    const quotes = {
        happy: "Keep smiling, life is beautiful!",
        content: "Stay content, happiness is within.",
        neutral: "Every day is a new opportunity.",
        sad: "It's okay to feel sad, better days are coming.",
        angry: "Take a deep breath, calmness will prevail."
    };

    moodIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent any default behavior
            selectedMood = this.dataset.mood;
            motivationalQuote.textContent = quotes[selectedMood];
        });
    });

    const entryForm = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entryImage = document.getElementById("entry_image");
    const entriesContainer = document.getElementById("entries_container");
    const sortNewest = document.getElementById("sort_newest");
    const sortOldest = document.getElementById("sort_oldest");
    const submitCombinedButton = document.getElementById("submitCombinedButton");

    submitCombinedButton.addEventListener("click", async function(event) {
        event.preventDefault();
        const entry = entryInput.value;
        const mood = selectedMood;
        const file = entryImage.files[0];
        const formData = new FormData();
        formData.append('entry', entry);
        formData.append('mood', mood);
        if (file) {
            formData.append('entry_image', file);
        }

        try {
            const response = await fetch('entry_handler.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.status === 'success') {
                loadEntries();
                entryInput.value = '';
                entryImage.value = '';
                alert(data.message);
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });

    const loadEntries = async (sortOrder = 'DESC') => {
        try {
            const response = await fetch(`entry_handler.php?type=diary&sort=${sortOrder}`);
            const data = await response.json();
            displayEntries(data);
        } catch (error) {
            console.error("Error:", error);
        }
    };

    const loadMoodEntries = async (sortOrder = 'DESC') => {
        try {
            const response = await fetch(`entry_handler.php?type=mood&sort=${sortOrder}`);
            const data = await response.json();
            displayMoodEntries(data);
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
                <button class="edit-button" data-id="${entry.id}">Edit</button>
                <button class="delete-button" data-id="${entry.id}">Delete</button>
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

    const displayMoodEntries = (entries) => {
        moodEntriesContainer.innerHTML = '<h2>Mood Entries</h2>';
        entries.forEach(entry => {
            const entryDiv = document.createElement('div');
            entryDiv.classList.add('entry');
            entryDiv.innerHTML = `
                <p>Mood: ${entry.mood}</p>
                <span class="timestamp">${entry.entry_date}</span>
            `;
            moodEntriesContainer.appendChild(entryDiv);
        });
    };

    const editEntry = async (entryId) => {
        const newContent = prompt("Edit your entry:");
        if (newContent !== null) {
            try {
                const response = await fetch('entry_handler.php', {
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
                const response = await fetch('entry_handler.php', {
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
        loadEntries('DESC');
        loadMoodEntries('DESC');
    });

    sortOldest.addEventListener('click', () => {
        loadEntries('ASC');
        loadMoodEntries('ASC');
    });

    loadEntries();
    loadMoodEntries();
});
