<form id="add-unit-form" action="index.html" method="post">
    <table class="wp-list-table widefat fixed striped pages">
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
                            <?php if (isset($_GET["button"]) && $_GET["button"] == 'update' && isset($_GET["id_rank"])): ?>
                                <input type="hidden" name="method" value="update">
                                <input type="hidden" name="id_rank" value="<?php echo $_GET["id_rank"] ?>">
                                <?php $currentUnit = new LythRankingSettings($_GET["id_rank"]); ?>
                                <?php $mode = 'update'; ?>
                                <?php $unit_name = $currentUnit->unit_name; ?>
                                <?php $category = $currentUnit->category; ?>
                                <?php $unit_rank = $currentUnit->unit_rank; ?>
                                <?php $image_url = $currentUnit->image_url; ?>
                                <?php $url_post = $currentUnit->url_post; ?>
                                <?php $positive_details = maybe_unserialize($currentUnit->positive_details); ?>
                                <?php $negative_details = maybe_unserialize($currentUnit->negative_details); ?>
                            <?php else: ?>
                                <input type="hidden" name="method" value="add">
                                <?php $mode = 'add'; ?>
                                <?php $unit_name = ''; ?>
                                <?php $unit_rank = 1; ?>
                                <?php $category = 0; ?>
                                <?php $image_url = ''; ?>
                                <?php $url_post = ''; ?>
                                <?php $positive_details = NULL; ?>
                                <?php $negative_details = NULL; ?>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                            <div class="group-form-horizontal">
                                <label for="unit_rank">#</label>
                                <input type="number" name="unit_rank" value="<?php echo $unit_rank ?>" placeholder="<?php echo $unit_rank ?>" pattern="[0-9]" min="1">
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="group-form-horizontal">
                                <input type="text" name="unit_name" value="<?php echo $unit_name ?>" placeholder="<?php if($unit_name != '') echo $unit_name; else echo 'Unit Name';?>">
                                <input id="url_post" type="text" name="url_post" value="<?php echo $url_post ?>" placeholder="<?php if($url_post != '') echo $url_post; else echo 'Url Post Unit';?>">
                            </div>
                        </td>
                        <td colspan="1"></td>
                        <td>
                            <div class="form-group" id="image_url_group" style="<?php if($image_url) echo 'display:none;'; ?>">
                                <input type="hidden" name="image_url" id="image_url" class="text" value="<?php echo $image_url ?>">
                                <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
                            </div>
                            <div class="image_group" style="<?php if($image_url) echo 'display:flex;'; ?>">
                                <img  src="<?php echo $image_url ?>" alt="" id="upload_image">
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
                                                <option <?php if ($category == $child->id_category) echo "selected";?> value="<?php echo $child->id_category ?>" > » <?php echo $child->name ?></option>
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
            <tbody id="tbody_details">
                <?php if ($positive_details): ?>
                    <?php $countPos = count($positive_details); ?>
                    <?php $countNeg = count($negative_details); ?>
                    <?php if ($countNeg > $countPos): ?>
                        <?php $count = $countNeg; ?>
                    <?php else: ?>
                        <?php $count = $countPos; ?>
                    <?php endif; ?>
                    <?php for ($i=0; $i < $count; $i++) { ?>
                        <tr id="details_<?php echo $i?>">
                            <td colspan="1"></td>
                            <td colspan="3">
                                <?php if (isset($positive_details[$i])): ?>
                                    <?php $currentPositive = $positive_details[$i]; ?>
                                <?php else: ?>
                                    <?php $currentPositive = ''; ?>
                                <?php endif; ?>
                                <input type="text"  name="positive_details[<?php echo $i?>]" value="<?php echo $currentPositive?>" placeholder="<?php echo $currentPositive?>"></input>
                            </td>
                            <td colspan="3">
                                <?php if (isset($negative_details[$i])): ?>
                                    <?php $currentNegative = $negative_details[$i]; ?>
                                <?php else: ?>
                                    <?php $currentNegative = ''; ?>
                                <?php endif; ?>
                                <input type="text"  name="negative_details[<?php echo $i?>]" value="<?php echo $currentNegative?>" placeholder="<?php echo $currentNegative?>"></input>
                            </td>
                            <td colspan="1">
                            <?php if ($i > 0): ?>
                                <i class="close-row icon-cancel-circled">
                            <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr id="details_0">
                        <td colspan="1"></td>
                        <td colspan="3">
                            <input type="text"  name="positive_details[0]" value=""></input>
                        </td>
                        <td colspan="3">
                            <input type="text"  name="negative_details[0]" value=""></input>
                        </td>
                        <td colspan="1"></td>
                    </tr>
                <?php endif; ?>
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
    </table>
</form>
