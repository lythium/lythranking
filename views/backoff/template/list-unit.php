<table id="lythranking-list" class="wp-list-table widefat fixed striped pages">
    <thead>
        <tr>
            <th scope="col" id="field_0" class="manage-column column-cb id-column">ID</th>
            <th scope="col" id="field_1" class="manage-column column-title column-primary column-fields">Unit Rank</th>
            <th scope="col" id="field_2" class="manage-column column-fields">Unit Name</th>
            <th scope="col" id="field_4" class="manage-column column-fields">Image unit</th>
            <th scope="col" id="field_5" class="manage-column column-fields">Positive</th>
            <th scope="col" id="field_6" class="manage-column column-fields">Negative</th>
            <th scope="col" id="field_7" class="manage-column column-fields">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $objects = LythRankingCore::getCategoryParent(); ?>
        <?php if ($objects): ?>
            <?php foreach ($objects as $category): ?>
                <tr class="unit_category" style="background-color:<?php echo $category->color ?>;">
                    <td colspan="1"></td>
                    <td colspan="2">
                        <span><i class="icon-level-up"></i><?php echo $category->name ?></span>
                    </td>
                    <td colspan="4"></td>
                </tr>
                <?php $childrens = LythRankingCore::getChildrenCategory((int)$category->id_category); ?>
                <?php if ($childrens): ?>
                    <?php foreach ($childrens as $child): ?>
                        <tr class="unit_category_child">
                            <td colspan="2"></td>
                            <td colspan="2">
                                <span><i class="icon-level-up"></i><?php echo $child->name ?></span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <?php $results_units = LythRankingCore::getListRankByCategory($child->id_category); ?>
                        <?php if ($results_units): ?>
                            <?php foreach ($results_units as $unit): ?>
                                <tr class="unit">
                                    <td><?php echo $unit->id_rank ?></td>
                                    <td>#<?php echo $unit->unit_rank ?></td>
                                    <td><?php echo $unit->unit_name ?></td>
                                    <td>
                                        <div class="image_group" style="display:flex;">
                                            <img src="<?php echo $unit->image_url ?>" alt="" id="upload_image">
                                        </div>
                                    <td class="details_unit">
                                        <?php if ($unit->positive_details): ?>
                                            <ul>
                                                <?php $positive_details = maybe_unserialize($unit->positive_details); ?>
                                                <?php foreach ($positive_details as $positive): ?>
                                                    <li><?php echo $positive ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </td>
                                    <td class="details_unit">
                                        <?php if ($unit->negative_details): ?>
                                            <ul>
                                                <?php $negative_details = maybe_unserialize($unit->negative_details); ?>
                                                <?php foreach ($negative_details as $negative): ?>
                                                    <li><?php echo $negative ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form  action="<?= admin_url('admin.php') ?>" method="GET">
                                            <input type="hidden" name="page" value="lythrankinglist">
                                            <input type="hidden" name="id_rank" value="<?php echo $unit->id_rank ?>">
                                            <div class="btn-group">
                                                <button id="update_btn" type="submit" class="btn btn-info" name="button" value="update"></i><span class="icon_text">Update</span></button>
                                                <button class="btn-drop" type="button" name="button"><i class="icon-down-open"></i></button>
                                                <div class="dropdown">
                                                    <button id="delete_btn" type="submit" class="btn btn-info" name="button" value="delete"></i><span class="icon_text">Delete</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="no-items">
                                <td class="colspanchange" colspan="7">Sorry, No Unit for Category</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach;?>
                <?php else: ?>
                    <tr class="no-items">
                        <td class="colspanchange" colspan="7">Sorry, No child Category</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach;?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr class="no-items">
            <td class="colspanchange" colspan="7"> </td>
        </tr>
    </tfoot>
</table>
