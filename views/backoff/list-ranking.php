<?php
    if (isset($_GET["button"])) {
        if ($_GET["button"] === "delete_category" && !empty($_GET['id_category'])) {
            $obj_delete = new LythRankingSettingsCategory($_GET['id_category']);
            $obj_delete->deleteCategory();
        } elseif ($_GET["button"] === "delete_unit" && !empty($_GET['id_rank'])) {
            $unit_delete = new LythRankingSettings($_GET['id_rank']);
            $unit_delete->deleteUnit();
        }
    }
 ?>

<div id="acf-field-group-wrap" class="wrap lythranking">
    <div class="acf-columns-2">
        <h1 class="wp-heading-inline"><?= get_admin_page_title() ?></h1>
        <a class="page-title-action" href="<?= admin_url('admin.php?page=lythrankingaddcategory') ?>" class="page-title-action">Ajouter Category</a>
        <input type="hidden" id="url_page" value="<?= admin_url('admin.php?page=lythrankinglist') ?>">


    </div>
    <div>
        <div id="lythranking_success" class="alert alert-success" style="display:none;">
            <p></p>
            <i class="icon-cancel-circled"></i>
        </div>
        <div id="lythranking_error" class="alert alert-error" style="display:none;">
            <p></p>
            <i class="icon-cancel-circled"></i>
        </div>
    </div>
    <span>Shortcode : <strong>[Lythranking]</strong></span>

    <section id="section-1">
        <h3>List Category</h3>
        <table id="category-list" class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <th scope="col" id="field_0" class="manage-column column-cb id-column">ID</th>
                    <th scope="col" id="field_1" class="manage-column column-title column-primary column-fields">Category Name</th>
                    <th scope="col" id="field_2" class="manage-column column-fields">Parent</th>
                    <th scope="col" id="field_3" class="manage-column column-fields">Position</th>
                    <th scope="col" id="field_4" class="manage-column column-fields">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include_once plugin_dir_path(__FILE__).'template/list-category.php'; ?>
            </tbody>
            <tfoot>
                <tr class="no-items">
                    <td class="colspanchange" colspan="5"> </td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section id="section-2">
        <button id="form_unit" type="button" name="button" style="<?php if (isset($_GET['button']) && $_GET['button'] == 'update' ) echo 'display:none;'; ?>">Add Unit</button>
        <div id="table_add_unit" style="<?php if (isset($_GET['button']) && $_GET['button'] == 'update' ) echo 'display:block;'; ?>">
            <?php include_once plugin_dir_path(__FILE__).'template/add-unit.php'; ?>
        </div>
    </section>

    <section id="section-3">
        <h3>List Ranking</h3>
        <div id="table_list_unit">
            <?php include_once plugin_dir_path(__FILE__).'template/list-unit.php'; ?>
        </div>
    </section>

</div>
