
async function renderAppointments() {
  const appointmentsList = document.getElementById("appointmentsList");
  appointmentsList.innerHTML = ""; // Limpa a lista antes de renderizar

  try {
    const response = await fetch("http://localhost:8000/agenda-barbearia/server/agendamento");
    if (!response.ok) {
      throw new Error("Erro ao buscar agendamentos");
    }

    const appointments = await response.json();
    appointments.forEach(appointment => {
      const card = document.createElement("div");
      card.classList.add("appointment-card", "d-flex", "justify-content-between", "align-items-center");
      card.innerHTML = `
        <div>
          <h5>Cliente: ${appointment.nome == null ? '' : appointment.nome}</h5>
          <p>Status: ${appointment.status === 'P' ? "Pendente" : "Finalizado"}</p>
          <p>Data: ${appointment.data}</p>
          <p>Hora: ${appointment.hora}</p>
        </div>
        <div class="d-flex">
          <button class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#appointmentModal" onclick="editAppointment(${appointment.id})">
            <i class="bi bi-pencil-fill"></i> 
          </button>
          <button class="btn btn-custom" onclick="deleteAppointment(${appointment.id})">
            <i class="bi bi-trash-fill"></i> 
          </button>
        </div>
      `;
      appointmentsList.appendChild(card);
    });
  } catch (error) {
    console.error("Erro ao renderizar agendamentos:", error);
    appointmentsList.innerHTML = "<p>Não foi possível carregar os agendamentos.</p>";
  }
}


async function editAppointment(id) {
  console.log("Editando agendamento com ID:", id);

  try {
    await renderClientList();
    const response = await fetch(`http://localhost:8000/agenda-barbearia/server/agendamento/${id}`);
    const appointment = await response.json();

    document.getElementById('client').value = appointment.id_cliente;
    document.getElementById('date').value = appointment.data.split('/').reverse().join('-');
    document.getElementById('time').value = appointment.hora;

    document.getElementById('appointmentModalLabel').textContent = 'Editar Agendamento';

    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.onsubmit = async function (event) {
      event.preventDefault();

      const clientId = document.getElementById('client').value;
      const date = document.getElementById('date').value;
      const time = document.getElementById('time').value;
      const formattedDate = date.split('-').reverse().join('/');

      const appointmentData = {
        id_cliente: clientId,
        data: formattedDate,
        hora: time
      };

      try {
        const updateResponse = await fetch(`http://localhost:8000/agenda-barbearia/server/agendamento/${id}`, {
          method: 'PUT',
          body: JSON.stringify(appointmentData),
        });

        if (!updateResponse.ok) {
          throw new Error('Erro ao atualizar agendamento');
        }

        const confirmationMessage = document.getElementById('confirmationMessage');
        confirmationMessage.classList.remove('d-none');
        renderAppointments();

        setTimeout(() => {
          confirmationMessage.classList.add('d-none');
          const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
          appointmentModal.hide();
          resetForm();
        }, 2000);
      } catch (error) {
        console.error('Erro ao atualizar agendamento:', error);
      }
    };
  } catch (error) {
    console.error("Erro ao buscar agendamento:", error);
  }
}



async function deleteAppointment(id) {
  console.log("Excluindo agendamento com ID:", id);

  try {
    const response = await fetch(`http://localhost:8000/agenda-barbearia/server/agendamento/${id}`, {
      method: "DELETE",
    });

    if (!response.ok) {
      throw new Error("Erro ao excluir agendamento");
    }

    console.log(`Agendamento com ID ${id} excluído com sucesso!`);

    renderAppointments();

  } catch (error) {
    console.error("Erro ao excluir agendamento:", error);
    alert("Não foi possível excluir o agendamento.");
  }
}

// Chama a função para renderizar os agendamentos
renderAppointments();

async function renderClientList() {
  console.log("TO AQ");

  fetch('http://localhost:8000/agenda-barbearia/server/cliente')
    .then(response => response.json())  // Converte a resposta para JSON
    .then(data => {
      const clientSelect = document.getElementById('client');  // Obtém o elemento select
      clientSelect.innerHTML = `<option value="" disabled selected>Selecione o cliente</option>`  // Obtém o elemento select
      console.log(data);
      data.forEach(cliente => {
        const option = document.createElement('option');
        option.value = cliente.id;  // Define o valor da option como o ID do cliente
        option.textContent = cliente.nome;  // Define o texto visível como o nome do cliente
        clientSelect.appendChild(option);  // Adiciona a opção ao select
      });
    })
    .catch(error => {
      console.error('Erro ao carregar clientes:', error);
    });

}

document.getElementById('newAppointmentBtn').addEventListener('click', async function (event) {
  resetForm();
  await renderClientList();
})
function resetForm() {
  const appointmentForm = document.getElementById('appointmentForm');
  appointmentForm.reset();
  document.getElementById('appointmentModalLabel').textContent = 'Agende seu Horário';
  appointmentForm.onsubmit = handleNewAppointment;
}


function handleNewAppointment(event) {
  event.preventDefault();

  const clientId = document.getElementById('client').value;
  const date = document.getElementById('date').value;
  const time = document.getElementById('time').value;
  const formattedDate = date.split('-').reverse().join('/');

  const appointmentData = {
    id_cliente: clientId,
    data: formattedDate,
    hora: time
  };

  fetch('http://localhost:8000/agenda-barbearia/server/agendamento', {
    method: 'POST',
    body: JSON.stringify(appointmentData)
  })
    .then(response => response.json())
    .then(() => {
      const confirmationMessage = document.getElementById('confirmationMessage');
      confirmationMessage.classList.remove('d-none');
      renderAppointments();

      setTimeout(() => {
        confirmationMessage.classList.add('d-none');
        const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
        appointmentModal.hide();
        resetForm();
      }, 2000);
    })
    .catch(error => {
      console.error('Erro ao agendar:', error);
    });
}


// Função para renderizar a lista de clientes no modal
async function renderClientListModal() {
  try {
    const response = await fetch('http://localhost:8000/agenda-barbearia/server/cliente');
    const clients = await response.json();

    const clientsList = document.getElementById('clientsList');
    clientsList.innerHTML = ''; // Limpa a lista antes de renderizar

    // Cria cards para cada cliente
    clients.forEach(client => {
      const card = document.createElement('div');
      card.classList.add('client-card', 'd-flex', 'justify-content-between', 'align-items-center', 'p-3', 'border', 'mb-2', 'rounded');

      // Monta o conteúdo do card com os botões de editar e excluir
      card.innerHTML = `
        <div>
          <h5>${client.nome}</h5>
          <p>Telefone: ${client.telefone}</p>
        </div>
        <div class="d-flex">
          <button class="btn btn-custom me-2" onclick="editClient(${client.id})">
            <i class="bi bi-pencil-fill"></i>
          </button>
          <button class="btn btn-custom" onclick="deleteClient(${client.id})">
            <i class="bi bi-trash-fill"></i>
          </button>
        </div>
      `;
      clientsList.appendChild(card);
    });
  } catch (error) {
    console.error('Erro ao carregar lista de clientes:', error);
    document.getElementById('clientsList').innerHTML = "<p>Não foi possível carregar a lista de clientes.</p>";
  }
}

// Função para editar um cliente
async function editClient(id) {
  console.log("Editando cliente com ID:", id);

  try {
    const response = await fetch(`http://localhost:8000/agenda-barbearia/server/cliente/${id}`);
    const client = await response.json();

    // Preenche o modal com os dados do cliente
    document.getElementById('clientName').value = client.nome;
    document.getElementById('clientPhone').value = client.telefone;

    // Atualiza o título do modal para indicar edição
    document.getElementById('newClientModalLabel').textContent = 'Editar Cliente';

    // Define o comportamento do formulário para salvar edições
    const clientForm = document.getElementById('newClientForm');
    clientForm.onsubmit = async function (event) {
      event.preventDefault();

      const updatedClientData = {
        nome: document.getElementById('clientName').value,
        telefone: document.getElementById('clientPhone').value,
      };

      try {
        const updateResponse = await fetch(`http://localhost:8000/agenda-barbearia/server/cliente/${id}`, {
          method: 'PUT',
          body: JSON.stringify(updatedClientData),
        });

        if (!updateResponse.ok) {
          throw new Error('Erro ao atualizar cliente');
        }

        // Atualiza a lista de clientes
        renderClientListModal();

        // Fecha o modal e redefine o formulário
        const clientModal = bootstrap.Modal.getInstance(document.getElementById('newClientModal'));
        clientModal.hide();
        resetClientForm();
      } catch (error) {
        console.error('Erro ao atualizar cliente:', error);
      }
    };

    // Abre o modal
    const clientModal = new bootstrap.Modal(document.getElementById('newClientModal'));
    clientModal.show();

  } catch (error) {
    console.error("Erro ao buscar cliente:", error);
  }
}

// Função para redefinir o formulário e restaurar para modo de criação
function resetClientForm() {
  const clientForm = document.getElementById('newClientForm');
  clientForm.reset();
  document.getElementById('newClientModalLabel').textContent = 'Cadastrar Cliente';
  clientForm.onsubmit = handleNewClient; // Define o comportamento padrão de cadastro
}

// Função para cadastrar novo cliente
async function handleNewClient(event) {
  event.preventDefault();

  const data = {
    nome: document.getElementById('clientName').value,
    telefone: document.getElementById('clientPhone').value
  };

  try {
    const response = await fetch('http://localhost:8000/agenda-barbearia/server/cliente', {
      method: 'POST',
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error('Erro ao cadastrar cliente');
    }

    // Atualiza a lista de clientes
    renderClientListModal();

    // Fecha o modal e redefine o formulário
    const clientModal = bootstrap.Modal.getInstance(document.getElementById('newClientModal'));
    clientModal.hide();
    resetClientForm();
  } catch (error) {
    console.error('Erro ao cadastrar cliente:', error);
  }
}

// Função para excluir um cliente
async function deleteClient(id) {
  try {
    const response = await fetch(`http://localhost:8000/agenda-barbearia/server/cliente/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error('Erro ao excluir cliente');
    }

    console.log(`Cliente com ID ${id} excluído com sucesso!`);
    renderClientListModal(); // Atualiza a lista de clientes
  } catch (error) {
    console.error('Erro ao excluir cliente:', error);
  }
}

// Carrega a lista de clientes ao abrir o modal
document.getElementById('clientsModal').addEventListener('show.bs.modal', renderClientListModal);

// Botão para abrir modal de novo cliente
document.getElementById('botaoAbreCliente').onclick = resetClientForm;

