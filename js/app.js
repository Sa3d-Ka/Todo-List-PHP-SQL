const listContainer = $("#list-container");

$.ajax({
  url: "server/api/list_tasks.php",
  type: "GET",
  dataType: "json",
  success: afficherTaches,
  error: (jqXHR, textStatus, errorThrown) => {
    alert("Erreur AJAX : " + textStatus + " (" + jqXHR.status + ")");
    console.error("Détail : ", errorThrown);
  },
});

function afficherTaches(tasks) {
  listContainer.empty();

  tasks.forEach((task) => {
    const isChecked = task.done == 1;
    const liClass = isChecked ? "checked" : "";
    const iconClass = isChecked
      ? "fa-solid fa-circle-check"
      : "fa-regular fa-circle-check";

    const li = $(`
            <li class="${liClass}" data-id="${task.id}">
                <div class="taskC">
                    <i class="${iconClass} toggle"></i>
                    <span>${task.title}</span>
                </div>
                <div class="actions">
                    <button class="deleteBtn" id="deleteBtn"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            </li>
        `);

    listContainer.append(li);
  });
}

$("#addTaskBtn").click(() => {
  const title = $("#input-box").val();
  console.log(title);

  $.ajax({
    url: "server/api/add_task.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({ title }),
    dataType: "json",
    success: (t) => ajouterTacheDOM(t),
    error: (jq) => console.error("Add error:", jq.status),
  });
  $("#input-box").val('');
});

function ajouterTacheDOM(t) {
  const li = $(`
            <li data-id="${t.id}">
                <div class="taskC">
                    <i class="fa-regular fa-circle-check toggle"></i>
                    <span>${t.title}</span>
                </div>
                <div class="actions">
                    <button class="deleteBtn"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            </li>
        `);

  listContainer.append(li);
}