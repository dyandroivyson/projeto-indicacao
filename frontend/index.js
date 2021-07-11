function loadTable() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost:8000/api/indicacao");
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var trHTML = '';
            const objects = JSON.parse(this.responseText);
            for (let object of objects) {
                trHTML += '<tr>';
                trHTML += '<td>' + object['nome'] + '</td>';
                trHTML += '<td>' + object['cpf'].replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4') + '</td>';
                trHTML += '<td>' + object['telefone'].replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1)$2-$3') + '</td>';
                trHTML += '<td>' + object['email'] + '</td>';
                trHTML += '<td>' + object['status_indicacao']['descricao'] + '</td>';
                trHTML += '<td><button type="button" class="btn btn-outline-secondary" onclick="alterarStatus(' + object['id'] + ')">Alterar Status</button>';
                trHTML += '<button type="button" class="btn btn-outline-danger" onclick="excluirIndicacao(' + object['id'] + ')">Excluir</button></td>';
                trHTML += "</tr>";
            }
            document.getElementById("mytable").innerHTML = trHTML;
        }
    };
}

function boxCadastrarIndicacao() {
    Swal.fire({
        title: 'Cadastrar Indicação',
        html:
            '<input id="id" type="hidden">' +
            '<input id="nome" class="swal2-input" placeholder="Nome">' +
            '<input id="cpf" class="swal2-input" placeholder="CPF">' +
            '<input id="telefone" class="swal2-input" placeholder="Telefone">' +
            '<input id="email" class="swal2-input" placeholder="E-mail">',
        didOpen: function() {
            $('#cpf').inputmask('999.999.999-99');
            $('#telefone').inputmask('(99)99999-9999');
        },
        focusConfirm: false,
        preConfirm: () => {
            cadastrarIndicacao();
        }
    })
}

function cadastrarIndicacao() {
    const nome = document.getElementById("nome").value;
    const cpf = document.getElementById("cpf").value;
    const telefone = document.getElementById("telefone").value;
    const email = document.getElementById("email").value;

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost:8000/api/indicacao");
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(JSON.stringify({
        "nome": nome,
        "cpf": cpf,
        "telefone": telefone,
        "email": email
    }));
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 201) {
            const objects = JSON.parse(this.responseText);
            Swal.fire(objects['msg']);
            
            loadTable();
        } else {
            const objects = JSON.parse(this.responseText);
            
            let values = '';
            Object.entries(objects['msg']).forEach(entry => {
                const [key, value] = entry;

                values += value+'<br>';
            });

            Swal.fire(values);
        }
    };
}

function alterarStatus(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("PUT", "http://localhost:8000/api/indicacao");
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(JSON.stringify({
        "id": id
    }));
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            const objects = JSON.parse(this.responseText);
            Swal.fire(objects['msg']);
            loadTable();
        }
    };
}

function excluirIndicacao(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", "http://localhost:8000/api/indicacao");
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(JSON.stringify({
        "id": id
    }));
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            const objects = JSON.parse(this.responseText);
            Swal.fire(objects['msg']);
            loadTable();
        }
    };
}

loadTable();