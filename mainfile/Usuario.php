<?php require_once(__DIR__ . '/header.php'); ?>
    <div style="text-align: right; margin: 20px 0px 10px;">
        <a id="btnAddAction" href="index.php?action=usuario-add"><img src="image/icon-add.png" />Agregar Usuario</a>
    </div>
    <div id="toys-grid">
        <table cellpadding="10" cellspacing="1">
            <thead>
                <tr>
                    <th><strong>Usuario</strong></th>
                    <th><strong>Rol</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (! empty($result)) {
                    foreach ($result as $k => $v) {
                ?>
                <tr>
                    <td><?php echo $result[$k]["usuario"]; ?></td>
                    <td><?php echo $result[$k]["rol"]; ?></td>
                    <td><a class="btnEditAction"
                        href="index.php?action=usuario-edit&id=<?php echo $result[$k]["id"]; ?>">
                        <img src="image/icon-edit.png" />
                        </a>
                        <?php
                    if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1) {
                        ?>
                        <a onclick="return confirm('Confirma Eliminar Registro?');" class="btnDeleteAction" 
                        href="index.php?action=usuario-delete&id=<?php echo $result[$k]["id"]; ?>">
                        <img src="image/icon-delete.png" />
                        </a><?php
                    }
                    ?>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            <tbody>
        
        </table>
    </div>
</body>
</html>