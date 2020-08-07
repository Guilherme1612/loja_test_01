<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$employee = Container::getModel('Employee');
		$this->view->employee = $employee->getAll();
		$this->render('index');
	}
	
	public function registerEmployee() {
		if (strlen($_POST['nome']) <= 0 || strlen($_POST['cargo']) <= 0 || strlen($_POST['data_nascimento']) <= 0 || strlen($_POST['data_admissao']) <= 0){
            echo "<script>alert('Preencha todos os campos para realizar o cadastro!')</script>";
		}
		else {
			$employee = Container::getModel('Employee');
			$employee->nome = $_POST['nome'];
			$employee->cargo = $_POST['cargo'];
			$employee->data_nascimento = $_POST['data_nascimento'];
			$employee->data_admissao = $_POST['data_admissao'];
			$employee->registerEmployee();
			echo "<script>alert('Funcionário cadastrado com sucesso!')</script>";
		}
		echo "<script> location.href = '/' </script>";
	}

	public function editEmployee() {
        $this->render('edit_employee');
	}
	
	public function updateEmployee() {
		if (!empty($_POST['id'])) { 
			$employee = Container::getModel('Employee');
			$employee->id = $_POST['id'];
			$employee->nome = $_POST['nome'];
			$employee->cargo = $_POST['cargo'];
			$employee->data_nascimento = $_POST['data_nascimento'];
			$employee->data_admissao = $_POST['data_admissao'];
			$employee->updateEmployee();
			echo "<script> alert('Dados atualizados com sucesso!') </script>";
		}
		else {
			echo "<script> alert('Selecione um registro para atualizar os dados!') </script>";
		}
		echo "<script> location.href = '/' </script>";	
	}

	public function removeEmployee() {
		$this->render('remove_employee');
	}

	public function deleteEmployee() {
		if (!empty($_POST['id'])) {
			$employee = Container::getModel('Employee');
			$employee->id = $_POST['id'];
			$employee->deleteEmployee();
			echo "<script> alert('Funcionário removido com sucesso!') </script>";
		} 
		else {
			echo "<script> alert('Selecione um registro para realizar a remoção!') </script>";
		}
		echo "<script> location.href = '/' </script>";
	}

	public function exportEmployee() {
        $employee = Container::getModel('Employee');
        
        $arquivo = '';

        // Formatando estilo da tabela
        $style_first_header = "height: 60px; font-size:22px; text-align:center; background-color:#1EA39C; color:#FFFFFF; display:table-cell; vertical-align:middle;";
        $style_second_header_name = "height: 45px; width: 300px; text-align:center; background-color:#F7F7F7; display:table-cell; vertical-align:middle;";
        $style_second_header = "height: 45px; width: 200px; text-align:center; background-color:#F7F7F7; display:table-cell; vertical-align:middle;";
        $style_titile_header = "font-size:20px";
        $style_content = "height:32px; text-align:center; font-size:20;  display:table-cell; vertical-align:middle";

        if($_POST['categoria'] == 'Todos os funcionários' && $_POST['data_admissao'] == ''){
			
			$arquivo = 'relacao_funcionarios.xls';

            // Criando uma tabela HTML com o formato da planilha
            $html = '';
            $html .= '<meta charset="utf-8"/>';
            $html .= '<table border="1">';
            $html .= "<tr>";
            $html .= "<td colspan='4' style='$style_first_header'><h2>Relação de funcionários</h2></td>";
            $html .= "</tr>";
            $html .= '<tr>';
            $html .= "<td style='$style_second_header_name'><h4 style='$style_titile_header'>Nome</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Cargo</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Data de nascimento</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Data de admissão</h4></td>";
            $html .= '</tr>';
            foreach($employee->getAll() as $e){
                $html .= "<tr style='$style_content'>";
                $html .= '<td>'.$e["nome"].'</td>';
                $html .= '<td>'.$e['cargo'].'</td>';
                $html .= '<td>'.date('d/m/Y', strtotime($e["data_nascimento"])).'</td>';
                $html .= '<td>'.date('d/m/Y', strtotime($e["data_admissao"])).'</td>';
                $html .= '</tr>';
            }
        }  
        else if($_POST['categoria'] == 'Por data de admissão' && strlen($_POST['data_admissao']) == 10){

			$arquivo = 'relacao_funcionarios.xls';

            $employee->data_admissao = $_POST['data_admissao'];
			$data_admissao = date('d/m/Y', strtotime($_POST['data_admissao']));
			
            // Criando uma tabela HTML com o formato da planilha
            $html = '';
            $html .= '<meta charset="utf-8"/>';
            $html .= '<table border="1">';
            $html .= "<tr>";
            $html .= "<td colspan='4' style='$style_first_header'><h2>Relação de funcionários admitidos em - $data_admissao</h2></td>";
            $html .= "</tr>";
            $html .= '<tr>';
            $html .= "<td style='$style_second_header_name'><h4 style='$style_titile_header'>Nome</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Cargo</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Data de nascimento</h4></td>";
            $html .= "<td style='$style_second_header'><h4 style='$style_titile_header'>Data de admissão</h4></td>";
            $html .= '</tr>';
            foreach($employee->getAllEmployeesFilter() as $e){
                $html .= "<tr style='$style_content'>";
                $html .= '<td>'.$e["nome"].'</td>';
                $html .= '<td>'.$e['cargo'].'</td>';
                $html .= '<td>'.date('d/m/Y', strtotime($e["data_nascimento"])).'</td>';
                $html .= '<td>'.date('d/m/Y', strtotime($e["data_admissao"])).'</td>';
                $html .= '</tr>';
            }
        } 
        else if($_POST['categoria'] == 'Por data de admissão' && (strlen($_POST['data_admissao']) != 10)){
            echo "<script>
                alert('Digite uma data válida para exportar os registros!');
                location.href = '/'
            </script>";
        } 
        else{
            echo "<script>
                alert('Erro ao exportar registros, tente novamente mais tarde!');
                location.href = '/'
            </script>";
        }
        
		if(strlen($arquivo) > 3){
            // // Configurações header para forçar o download
            header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            header ("Content-type: application/x-msexcel");
            header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
            header ("Content-Description: PHP Generated Data" );
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        }
	}
}

?>