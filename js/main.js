const taskInput = document.getElementById('taskInput');
const taskDate = document.getElementById('taskDate');
const addTaskBtn = document.getElementById('addTask');
const taskTable = document.getElementById('taskTable');

let tasks = JSON.parse(localStorage.getItem('tasks')) || [];

function saveTasks() {
  localStorage.setItem('tasks', JSON.stringify(tasks));
  renderTasks();
}

function renderTasks() {
  taskTable.innerHTML = '';
  let completed = 0;

  tasks.forEach((task, index) => {
    const tr = document.createElement('tr');
    tr.className = task.completed ? 'todo-item completed' : 'todo-item';

    tr.innerHTML = `
      <td>${task.text}</td>
      <td>${task.date || '-'}</td>
      <td>${task.completed ? 'Completed' : 'Pending'}</td>
      <td class="flex gap-2">
        <button class="btn btn-success btn-sm" onclick="toggleComplete(${index})"><i class="bx bx-check"></i></button>
        <button class="btn btn-error btn-sm" onclick="deleteTask(${index})"><i class="bx bx-trash"></i></button>
      </td>
    `;
    taskTable.appendChild(tr);

    if(task.completed) completed++;
  });

  document.getElementById('totalCount').innerText = tasks.length;
  document.getElementById('completedCount').innerText = completed;
  document.getElementById('pendingCount').innerText = tasks.length - completed;
  document.getElementById('progressPercent').innerText = tasks.length ? Math.round((completed/tasks.length)*100)+'%' : '0%';
}

function toggleComplete(index) {
  tasks[index].completed = !tasks[index].completed;
  saveTasks();
}

function deleteTask(index) {
  tasks.splice(index,1);
  saveTasks();
}

addTaskBtn.addEventListener('click', () => {
  const text = taskInput.value.trim();
  const date = taskDate.value;
  if(!text) return alert("Task cannot be empty!");
  tasks.push({ text, date, completed: false });
  saveTasks();
  taskInput.value = '';
  taskDate.value = '';
});

renderTasks();
