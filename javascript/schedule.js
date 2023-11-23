function generateCalendar() {
    var selectedLesson = document.getElementById('lesson').value;
    var selectedLevel = document.getElementById('level').value;
    var calendarBody = document.getElementById('calendarBody');
  
    // Example lesson data for various combinations (replace this with data from the backend)
    var lessonData = getExampleData(selectedLesson, selectedLevel);
  
    // Clear existing rows
    calendarBody.innerHTML = '';
  
    // Generate new rows based on the lessonData
    lessonData.forEach(function (row) {
      var newRow = document.createElement('tr');
  
      // Create cells for each day
      Object.keys(row).forEach(function (day) {
        var newCell = document.createElement('td');
        newCell.textContent = row[day];
        newRow.appendChild(newCell);
      });
  
      calendarBody.appendChild(newRow);
    });
  }
  
  // Example function to generate data for various lesson and level combinations
  function getExampleData(lesson, level) {
    // Map of lessons and their schedules for each level
    var lessonSchedules = {
      math: {
        FirstLyceum: [
          { time: '8:00 AM', monday: 'Math Lesson 1', tuesday: '', wednesday: 'Math Lesson 2', thursday: '', friday: 'Math Lesson 3', saturday: '', sunday: 'Math Lesson 4' },
          { time: '9:00 AM', monday: '', tuesday: 'Math Lesson 5', wednesday: '', thursday: 'Math Lesson 6', friday: '', saturday: 'Math Lesson 7', sunday: '' },
        ],
        SecondLyceum: [
          { time: '8:00 AM', monday: 'Math Lesson 1', tuesday: '', wednesday: 'Math Lesson 2', thursday: '', friday: 'Math Lesson 3', saturday: '', sunday: 'Math Lesson 4' },
          { time: '9:00 AM', monday: '', tuesday: 'Math Lesson 5', wednesday: '', thursday: 'Math Lesson 6', friday: '', saturday: 'Math Lesson 7', sunday: '' },
          { time: '10:00 AM', monday: 'Math Lesson 1', tuesday: '', wednesday: 'Math Lesson 2', thursday: '', friday: 'Math Lesson 3', saturday: '', sunday: 'Math Lesson 4' },
          { time: '11:00 AM', monday: '', tuesday: 'Math Lesson 5', wednesday: '', thursday: 'Math Lesson 6', friday: '', saturday: 'Math Lesson 7', sunday: '' },
        ],
        ThirdLyceum: [
          // Define advanced schedule for math...
        ],
      },
      physics: {
        // Define schedules for physics...
      },
      biology: {
        // Define schedules for biology...
      },
      // Add more lessons as needed
    };
  
    return lessonSchedules[lesson][level] || [];
  }