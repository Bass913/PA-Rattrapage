<div class="content-post">
    <h1 style="text-align: center;">Liste des articles</h1>
    <div class="container">
        <div class="row">
            <table class="pa-table col-xs-12">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Auteur</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Commentaires</th>
                        <th>Date</th>
                        <th>Editer</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                        foreach($posts as $value) { ?>
                        <td><?= $value['post_id'] ?></td>
                        <td><?= $value['post_author'] ?></td>
                        <td><?= $value['post_title'] ?></td>
                        <td><?= $value['post_category_id'] ?></td>
                        <td><?= $value['post_status'] ?></td>
                        <td><?= $value['post_image'] ?></td>
                        <td><?= $value['post_tags'] ?></td>
                        <td><?= $value['post_comment_count'] ?></td>
                        <td><?= $value['post_date'] ?></td>
                        <td><a href="">Editer</a></td>
                        <td><a href="">Supprimer</a></td>
                        
                    </tr> <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>