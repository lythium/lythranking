<div id="acf-field-group-wrap" class="wrap lythrankingaddcategory">
    <div class="acf-columns-2">
        <h1 class="wp-heading-inline"><?= get_admin_page_title() ?></h1>
        <a class="page-title-action" href="<?= admin_url('admin.php?page=lythrankinglist') ?>" class="page-title-action">Retour</a>

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
    <div class="separator" style="display:block;margin-top:40px;"></div>
    <h3>Category</h3>
    <div id="two-column">
        <section id="first-col">
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
                   <?php $results = LythRankingCore::getListCategory(); ?>
                   <?php if ($results): ?>
                   <?php else: ?>
                       <tr class="no-items">
                           <td class="colspanchange" colspan="5">Sorry, No rank Category</td>
                       </tr>
                   <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="no-items">
                        <td class="colspanchange" colspan="5"> </td>
                    </tr>
                </tfoot>
            </table>
        </section>
        <section id="second-col">
            <form id="add-category" action="" method="post">
                <div class="group-form">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="">
                </div>
                <div class="group-form">

                </div>
            </form>
        </section>
    </div>
</div>
