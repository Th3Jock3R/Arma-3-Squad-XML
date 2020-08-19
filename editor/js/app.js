var ranks = [
    'Admin',
    'Moderator',
    'Supporter',
    'Veteran',
    'Mitglied',
    'Bewerber',
    'Rekrut',
];

document.getElementById('addRow').addEventListener('click', e => {
    var lc = document.getElementById('members');

    //var row = document.createElement('tr');
    var id = lc.children.length + 1;

    var row = lc.insertRow(lc.children.length);

    ['id', 'nick', 'name'].forEach((el, i) => {
        var col = row.insertCell(i);
        var input = document.createElement('input');
        input.setAttribute('name', 'member[' + id + '][' + el + ']');
        input.setAttribute('type', 'text');

        input.required = true;

        if (el === "name") {
            input.value = "N/A";
        }

        input.classList.add('form-control');
        var cell = document.createElement('td').appendChild(input)
        col.appendChild(cell);
    });

    var col = row.insertCell(row.children.length);
    var select = document.createElement('select');
    select.setAttribute('name', 'member[' + id + '][remark]');
    select.classList.add('form-control');

    ranks.forEach(e => {
        var option = document.createElement('option');
        option.value = e;
        option.innerText = e;

        if (e === "Mitglied") {
            option.selected = true;
        }

        select.appendChild(option);
    });

    var cell = document.createElement('td').appendChild(select)
    col.appendChild(cell);

    var col = row.insertCell(row.children.length);
    col.classList.add('text-right')

    var button = document.createElement('button');

    button.setAttribute('type', 'button');
    button.classList.add('btn', 'btn-danger', 'delete');
    button.innerText = 'Löschen';
    button.addEventListener('click', e => {
        (e.target.closest('tr')).remove();
    });
    col.appendChild(button);
});


document.querySelectorAll('button.delete').forEach(x => {
    x.addEventListener('click', x => {
        (x.target.closest('tr')).remove();
    });
})
