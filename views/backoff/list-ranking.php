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
        <button id="form_unit" type="button" name="button">Add Unit</button>
        <div id="table_add_unit">
            <?php include_once plugin_dir_path(__FILE__).'template/add-unit.php'; ?>
        </div>
    </section>

    <section id="section-3">
        <h3>List Ranking</h3>
        <table id="lythranking-list" class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <th scope="col" id="field_0" class="manage-column column-cb id-column">ID</th>
                    <th scope="col" id="field_1" class="manage-column column-title column-primary column-fields">Unit Rank</th>
                    <th scope="col" id="field_2" class="manage-column column-fields">Unit Name</th>
                    <th scope="col" id="field_3" class="manage-column column-fields">Category</th>
                    <th scope="col" id="field_4" class="manage-column column-fields">Image unit</th>
                    <th scope="col" id="field_5" class="manage-column column-fields">Positive</th>
                    <th scope="col" id="field_6" class="manage-column column-fields">Negative</th>
                    <th scope="col" id="field_7" class="manage-column column-fields">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $results = LythRankingCore::getListRank(); ?>
                <?php if ($results): ?>
                <?php else: ?>
                    <tr class="no-items">
                        <td class="colspanchange" colspan="8">Sorry, No ranking</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="no-items">
                    <td class="colspanchange" colspan="8"> </td>
                </tr>
            </tfoot>
        </table>
    </section>

</div>
