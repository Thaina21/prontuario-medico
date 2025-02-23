<?php
  require __DIR__."/../vendor/autoload.php";
  require_once "Paciente.php";
  use Kreait\Firebase\Factory;
  use Ramsey\Uuid\Uuid;

  class ConnectionDB {
    private Factory $factoryDB;
    private $connectionDB;

    function __construct(){
      $this->factoryDB = (new Factory())->withDatabaseUri("https://prontuario-medico-2d0af-default-rtdb.firebaseio.com/");
      $this->connectionDB = $this->factoryDB->createDatabase();
    }

    // * COLEÇÃO PACIENTE
    //traz todos os pacientes da coleção de pacientes
    public function getColletionPaciente(){
      try{
        $allPacientes = $this->connectionDB->getReference("Paciente")->getSnapshot()->getValue();
        if(!$allPacientes){
          throw new Exception("Não há nenhum paciente na lista.");
        }
        return $allPacientes;
      }catch(Exception $err){
        return $err->getMessage();
      }

    }

    //traz um paciente pelo id dele
    public function getPacienteById($id){
      try{
        $paciente = $this->connectionDB->getReference("Paciente/".$id)->getSnapshot()->getValue();
        if(!$paciente){
          throw new Exception("Este id não foi encontrado.");
        }
        return $paciente;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz pacientes através do nome
    public function getPacienteByNome($nome){
      try{
        $paciente = $this->connectionDB->getReference("Paciente/")->orderByChild("nome")->equalTo($nome)->getSnapshot()->getValue();
        if(!$paciente){
          throw new Exception("Este nome não foi encontrado.");
        }
        return $paciente;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz um paciente através do cpf
    public function getPacienteByCpf($cpf){
      try{
        $paciente = $this->connectionDB->getReference("Paciente/")->orderByChild("cpf")->equalTo($cpf)->getSnapshot()->getValue();
        if(!$paciente){
          throw new Exception("Este cpf não foi encontrado.");
        }
        return $paciente;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //cria um novo paciente
    public function setNewPaciente(Paciente $newPaciente){
      $uuid = Uuid::uuid4();
      try{
        $paciente = $this->connectionDB->getReference("Paciente/".$uuid)->set([
          "nome" => $newPaciente->nome,
          "cpf" => $newPaciente->cpf,
          "telefone" => $newPaciente->telefone,
          "cep" => $newPaciente->cep,
          "endereco" =>$newPaciente->endereco,
          "sexo" => $newPaciente->sexo,
          "nascimento" =>$newPaciente->nascimento,
          "pai" =>$newPaciente->pai,
          "mae" =>$newPaciente->mae,
          "raca" =>$newPaciente->raca,
          "email" =>$newPaciente->email,
          "sangue" =>$newPaciente->sangue,
          "altura" =>$newPaciente->altura,
          "peso" =>$newPaciente->peso,
          "alergias" =>$newPaciente->alergias,
        ]);
        if(!$paciente){
          throw new Exception("Falha ao cadastrar o paciente.");
        }
        return "paciente criado com sucesso";
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //* COLEÇÃO CONSULTA
    //traz todas as consultas da coleção de consultas
    public function getColletionConsulta(){
      try{
        $allConsultas = $this->connectionDB->getReference("Consulta")->getSnapshot()->getValue();
        if(!$allConsultas){
          throw new Exception("Não há nenhuma consulta na lista.");
        }
        return $allConsultas;
      }catch(Exception $err){
        return $err->getMessage();
      }

    }

    //traz uma consulta pelo seu id
    public function getConsultaById($id){
      try{
        $consulta = $this->connectionDB->getReference("Consulta/".$id)->getSnapshot()->getValue();
        if(!$consulta){
          throw new Exception("Este id não foi encontrado.");
        }
        return $consulta;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz uma consulta ou mais pelo id do Paciente
    public function getConsultaByPacienteId($idPaciente){
      try{
        $consulta = $this->connectionDB->getReference("Consulta/")->orderByChild("idPaciente")->equalTo($idPaciente)->getSnapshot()->getValue();
        if(!$consulta){
          throw new Exception("Nenhuma consulta foi encontrada.");
        }
        return $consulta;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz uma consulta ou mais pelo id do Medico
    public function getConsultaByMedicoId($idMedico){
      try{
        $consulta = $this->connectionDB->getReference("Consulta/")->orderByChild("idMedico")->equalTo($idMedico)->getSnapshot()->getValue();
        if(!$consulta){
          throw new Exception("Nenhuma consulta foi encontrada.");
        }
        return $consulta;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //cria uma nova consulta no banco de dados
    public function setNewConsulta($idPaciente, $idMedico){
      $uuid = Uuid::uuid4();
      try{
        $consulta = $this->connectionDB->getReference("Consulta/".$uuid)->set([
          "idPaciente" => $idPaciente,
          "idMedico"=> $idMedico 
        ]);
        if(!$consulta){
          throw new Exception("Falha ao criar a consulta.");
        }
        return "consulta criada com sucesso";
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //* COLEÇÃO MÉDICO  
    //traz todos os médicos da coleção
    public function getColletionMedico(){
      try{
        $allMedicos = $this->connectionDB->getReference("Medico")->getSnapshot()->getValue();
        if(!$allMedicos){
          throw new Exception("Não há nenhum médico na lista.");
        }
        return $allMedicos;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz o médico pelo seu id
    public function getMedicoById($id){
      try{
        $medico = $this->connectionDB->getReference("Medico/".$id)->getSnapshot()->getValue();
        if(!$medico){
          throw new Exception("Este id não foi encontrado.");
        }
        return $medico;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz um médico ou mais pelo seu nome
    public function getMedicoByNome($nome){
      try{
        $medico = $this->connectionDB->getReference("Medico/")->orderByChild("nome")->equalTo($nome)->getSnapshot()->getValue();
        if(!$medico){
          throw new Exception("Este nome não foi encontrado.");
        }
        return $medico;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz um médico pelo seu CRM
    public function getMedicoByCRM($CRM){
      try{
        $medico = $this->connectionDB->getReference("Medico/")->orderByChild("CRM")->equalTo($CRM)->getSnapshot()->getValue();
        if(!$medico){
          throw new Exception("Este CRM não foi encontrado.");
        }
        return $medico;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //cadastra um novo médico
    public function setNewMedico($CRM, $nome){
      $uuid = Uuid::uuid4();
      try{
        $medico = $this->connectionDB->getReference("Medico/".$uuid)->set([
          "CRM" => $CRM,
          "nome" => $nome
        ]);
        if(!$medico){
          throw new Exception("Falha ao cadastrar o médico.");
        }
        return "médico criado com sucesso";
      }catch(Exception $err){
        return $err->getMessage();
      }
    }
    //* COLEÇÃO PRESCRIÇÃO
    //traz toda a coleção de prescrições
    public function getColletionPrescricao(){
      try{
        $allPrescricoes = $this->connectionDB->getReference("Prescricao")->getSnapshot()->getValue();
        if(!$allPrescricoes){
          throw new Exception("Não há nenhuma prescrição na lista.");
        }
        return $allPrescricoes;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz uma prescrição de acordo com o id do Médico
    public function getPrescricaoByMedicoId($id){
      try{
        $prescricoes = $this->connectionDB->getReference("Prescricao/")->orderByChild("idMedico")->equalTo($id)->getSnapshot()->getValue();
        if(!$prescricoes){
          throw new Exception("Nenhuma prescrição foi encontrada.");
        }
        return $prescricoes;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz uma prescrição de acordo com o id do Paciente
    public function getPrescricaoByPacienteId($id){
      try{
        $prescricoes = $this->connectionDB->getReference("Prescricao/")->orderByChild("idPaciente")->equalTo($id)->getSnapshot()->getValue();
        if(!$prescricoes){
          throw new Exception("Nenhuma prescrição foi encontrada.");
        }
        return $prescricoes;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }

    //traz uma prescrição de acordo com o id da Consulta
    public function getPrescricaoByConsultaId($id){
      try{
        $prescricoes = $this->connectionDB->getReference("Prescricao/")->orderByChild("idConsulta")->equalTo($id)->getSnapshot()->getValue();
        if(!$prescricoes){
          throw new Exception("Nenhuma prescrição foi encontrada.");
        }
        return $prescricoes;
      }catch(Exception $err){
        return $err->getMessage();
      }
    }


    //cria uma nova prescrição
    public function setNewPrescricao($idPaciente, $idMedico, $idConsulta){
      $uuid = Uuid::uuid4();
      try{
        $medico = $this->connectionDB->getReference("Prescricao/".$uuid)->set([
          "idMedico" => $idMedico,
          "idPaciente" => $idPaciente,
          "idConsulta" => $idConsulta
        ]);
        if(!$medico){
          throw new Exception("Falha ao criar a Prescrição.");
        }
        return "prescrição criada com sucesso";
      }catch(Exception $err){
        return $err->getMessage();
      }
    }
  }
?>