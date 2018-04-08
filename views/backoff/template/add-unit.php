<table class="wp-list-table widefat fixed striped pages">
    <form id="add-unit-form" action="index.html" method="post">
        <thead>
            <tr>
                <th scope="col" id="field_1" class="manage-column column-cb id-column">ID</th>
                <th scope="col" id="field_2" class="manage-column column-title column-primary column-fields">Unit Rank</th>
                <th colspan="2" scope="col" id="field_3" class="manage-column column-fields">Unit Name</th>
                <th scope="col" id="field_4" class="manage-column column-fields"></th>
                <th scope="col" id="field_5" class="manage-column column-fields">Image unit</th>
                <th scope="col" id="field_6" class="manage-column column-fields">Category</th>
                <th scope="col" id="field_7" class="manage-column column-fields"><i id="close_form_unit" class="icon-cancel-circled"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                    <td colspan="1">
                        <input type="hidden" name="method" value="add">
                        <?php $mode = 'add'; ?>
                    </td>
                    <td colspan="1">
                        <div class="group-form-horizontal">
                            <label for="unit_rank">#</label>
                            <input type="number" name="unit_rank" value="1" placeholder="1" pattern="[0-9]" min="1">
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="group-form-horizontal">
                            <input type="text" name="unit_name" value="" placeholder="Unit Name">
                            <input id="url_post" type="text" name="url_post" value="" placeholder="Link Unit Post">
                        </div>
                    </td>
                    <td colspan="1"></td>
                    <td>
                        <div class="form-group" id="image_url_group">
                            <input type="hidden" name="image_url" id="image_url" class="text" value="">
                            <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
                        </div>
                        <div class="image_group">
                            <img  src="" alt="" id="upload_image">
                            <a href="" id="close_upload"><i class="icon-cancel-circled"></i></a>
                        </div>
                    </td>
                    <td>
                        <select class="" name="category">
                            <?php $results = LythRankingCore::getCategoryParent(); ?>
                            <?php if ($results): ?>
                                <?php foreach ($results as $cat): ?>
                                    <option disabled value="<?php echo $cat->id_category ?>"><i class="icon-level-up"></i><?php echo $cat->name ?></option>
                                    <?php $resultsChildren = LythRankingCore::getChildrenCategory($cat->id_category) ?>
                                    <?php if ($resultsChildren): ?>
                                        <?php foreach ($resultsChildren as $child): ?>
                                            <option value="<?php echo $child->id_category ?>" > » <?php echo $child->name ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="0">No Category</option>
                            <?php endif; ?>
                        </select>
                    </td>
                    <td colspan="1"></td>
            </tr>
        </tbody>
        <thead>
            <tr>
                <th colspan="1" scope="col" id="field_1" class="manage-column column-cb id-column"></th>
                <th colspan="3" scope="col" id="field_2" class="manage-column column-fields">Positive</th>
                <th colspan="3" scope="col" id="field_3" class="manage-column column-fields">Negative</th>
                <th colspan="1" scope="col" id="field_4" class="manage-column column-fields"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1"></td>
                <td colspan="3">
                    <input type="text"  name="positive_details[]" value=""></input>
                </td>
                <td colspan="3">
                    <input type="text"  name="negative_details[]" value=""></input>
                </td>
                <td colspan="1"></td>
            </tr>
            <tr class="add-row">
                <td colspan="8">
                    <div class="group-form-horizontal">
                        <span><i id="icone-add-row"class="icon-cancel-circled"></i></span>
                    </div>
                </td>
            </tr>
            <tr class="last_row">
                <td colspan="2"></td>
                <td colspan="4">
                    <button id="btn-form" type="submit" name="button" value="add">
                        <i class="icon-spin5 animate-spin"></i>
                        <span class="icon_text"><?php if ($mode == 'update') echo "Update"; else echo "Add"; ?></span>
                    </button>
                </td>
                <td colspan="2"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="no-items">
                <td class="colspanchange" colspan="8"> </td>
            </tr>
        </tfoot>
    </form>
</table>
