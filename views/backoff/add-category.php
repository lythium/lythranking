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
            <form id="add-category">
                <?php if ($_GET["button"] == 'update' && isset($_GET["id_category"])): ?>
                    <input type="hidden" name="method" value="update">
                    <input type="hidden" name="id" value="<?php echo $_GET["id_category"] ?>">
                <?php else: ?>
                    <input type="hidden" name="method" value="add">
                <?php endif; ?>
                <div class="group-form-horizontal">
                    <div class="group-form">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="">
                    </div>
                    <div class="group-form">
                        <label for="position">Position</label>
                        <input type="text" name="position" value="0" pattern="[0-9]">
                    </div>
                </div>
                <div class="group-form-horizontal">
                    <label for="parent">Catégory parent</label>
                    <select class="" name="parent">
                        <?php $results = LythRankingCore::getCategoryParent(); ?>
                        <?php if ($results): ?>
                            <option value="0">No Category</option>
                            <?php foreach ($results as $cat): ?>
                                <option value="<?php echo $cat->id_category ?>"><?php echo $cat->name ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" name="button" value="add"><i class="icon-spin5 animate-spin"></i><span class="icon_text">Add</span></button>
            </form>
        </section>

        <section id="second-col">
            <div>
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
                        <?php $objects = LythRankingCore::getCategoryParent(); ?>
                        <?php if ($objects): ?>
                            <?php foreach ($objects as $obj): ?>
                                <tr>
                                    <th>
                                        <span><?php echo $obj->id_category ?></span>
                                    </th>
                                    <th>
                                        <span><?php echo $obj->name ?></span>
                                    </th>
                                    <th>
                                        <span></span>
                                    </th>
                                    <th>
                                        <span><?php echo $obj->position ?></span>
                                    </th>
                                    <th>
                                        <form  action="<?= admin_url('admin.php') ?>" method="GET">
                                            <input type="hidden" name="page" value="lythrankingaddcategory">
                                            <input type="hidden" name="id_category" value="<?php echo $obj->id_category ?>">
                                            <div class="btn-group">
                                                <button id="update_btn" type="submit" class="btn btn-info" name="button" value="update"></i><span class="icon_text">Update</span></button>
                                                <button class="btn-drop" type="button" name="button"><i class="icon-down-open"></i></button>
                                                <div class="dropdown">
                                                    <button id="delete_btn" type="submit" class="btn btn-info" name="button" value="delete"></i><span class="icon_text">Delete</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </th>
                                </tr>
                                <?php $childrens = LythRankingCore::getChildrenCategory((int)$obj->id_category); ?>
                                <?php if ($childrens): ?>
                                    <?php foreach ($childrens as $child): ?>
                                        <tr class="children">
                                            <th>
                                                <span><?php echo $child->id_category ?></span>
                                            </th>
                                            <th>
                                                <span><i class="icon-level-down"></i><?php echo $child->name ?></span>
                                            </th>
                                            <th>
                                                <span><?php echo $obj->name ?></span>
                                            </th>
                                            <th>
                                                <span><?php echo $child->position ?></span>
                                            </th>
                                            <th>
                                                <form  action="<?= admin_url('admin.php') ?>" method="GET">
                                                    <input type="hidden" name="page" value="lythrankingaddcategory">
                                                    <input type="hidden" name="id_category" value="<?php echo $child->id_category ?>">
                                                    <div class="btn-group">
                                                        <button id="update_btn" type="submit" class="btn btn-info" name="button" value="update"></i><span class="icon_text">Update</span></button>
                                                        <button class="btn-drop" type="button" name="button"><i class="icon-down-open"></i></button>
                                                        <div class="dropdown">
                                                            <button id="delete_btn" type="submit" class="btn btn-info" name="button" value="delete"></i><span class="icon_text">Delete</span></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </th>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif; ?>
                            <?php endforeach;?>
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
            </div>
        </section>
    </div>
</div>
