<?php       
require_once "../Dados/db.php";    
require_once "../Views/VerificaAdmin.php";    

class GridAdmin {   
    public function GridAdminHtml($data) {  

        if(count($data) === 0){
            return " <tr>
                        <td colspan='4' class='text-center py-5 text-muted'>
                            <i class='fas fa-users mb-3' style='font-size: 2rem; opacity: 0.3;'></i><br>
                            Nenhum usuário encontrado.
                        </td>
                    </tr>";
               
        }

        $html = "";
        foreach ($data as $row) {   
                $html .= "<tr>";
                $html .= " <td class='pl-4 py-3'>";
                $html .= "     <div class='d-flex align-items-center'>";
                $html .= "         <div class='avatar-placeholder mr-3 shadow-sm'>";
                $html .= sprintf("%s", htmlspecialchars(substr($row["Nome"], 0, 2)));
                $html .= "         </div>";
                $html .= "      <div>";
                $html .= sprintf("<div class='font-weight-bold text-dark'>%s</div>", htmlspecialchars($row["Nome"]));
                $html .= sprintf("<div class='small text-muted'>%s</div>", htmlspecialchars($row["Email"]));
                $html .= "      </div>";
                $html .= "     </div>";
                $html .= " </td>";
                $html .= sprintf(" <td class='text-muted font-weight-bold small'>#%s</td>", htmlspecialchars($row["Id"]));
                $html .= sprintf(" <td><span class='badge bg-light text-dark border'>%s anos</span></td>", htmlspecialchars($row["Idade"]));
                $html .= " <td class='text-right pr-4'>";
                $html .= "     <div class='dropdown'>";
                $html .= "         <button class='btn btn-outline-light btn-sm text-muted' type='button' data-toggle='dropdown' aria-expanded='false'>";
                $html .= "             <i class='fas fa-ellipsis-v'></i>";
                $html .= "         </button>";
                if ($_SESSION["usuario"]["tipo_usuario"] === "admin") {
                $html .= "         <ul class='dropdown-menu border-0 shadow'>";
                $html .= "             <li>";
                $html .= sprintf("                 <a href='form_editar.php?Id=%s' class='dropdown-item small'>", htmlspecialchars($row["Id"]));
                $html .= "                     <i class='fas fa-edit mr-2 text-primary'></i> Editar";
                $html .= "                 </a>";
                $html .= "             </li>";
                $html .= "             <li>";
                $html .= "                 <hr class='dropdown-divider'>";
                $html .= "             </li>"; 
                $html .= "             <li>";
                $html .= sprintf("                 <a href='Views/Deletar.php?Id=%s' class='dropdown-item small text-danger' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>", htmlspecialchars($row["Id"]));
                $html .= "                     <i class='fas fa-trash-alt mr-2'></i> Excluir"; 
                }else{
                $html .= "<span class='dropdown-item small text-muted' title='Ações indisponíveis para seu tipo de usuário'></span>";
                }
                $html .= "     </div>";
                $html .= " </td>";
                $html .= "</tr>";

        }
            return $html;
    }
}