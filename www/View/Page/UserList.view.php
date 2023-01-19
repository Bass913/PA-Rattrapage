<div class="container">
    <table id="datatable" class="pa-table display">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Édition</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <?php
        if (empty($userList)) { ?>
            <h1>Aucun utilisateur en base de données</h1>
        <?php } else { ?>
            <h1>Liste des utilisateurs</h1>
        <?php }
        ?>
        <tbody>
            <?php
            foreach ($userList as $user) {
                echo "<tr>
                            <td>" . $user['firstname'] . "</td>
                            <td>" . $user['lastname'] . "</td>
                            <td>" . $user['birthday'] . "</td>
                            <td>" . $user['email'] . "</td>
                            <td>" . $user['status'] . "</td>
                            <td><a href='/users?edit=" . $user['id'] . "'>Éditer</a></td>
                            <td><a href='/users?delete=" . $user['id'] . "'>Supprimer</a></td>";
            }
            ?>
        </tbody>
    </table>
    <?php
    if (isset($_GET['edit']) && !empty($userList)) {
        $this->includeComponent("form-edit-user", $editForm);
    }
    foreach ($configFormErrors as $error) : ?>
        <div>
            <p><?= $error ?> </p>
        </div>
    <?php endforeach; ?>
</div>