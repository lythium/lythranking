<div class="lythranking container-fluid">
    <div class="lr-container">
        <?php $mainCategory = LythRankingCore::getCategoryParent(); ?>
        <?php if ($mainCategory): ?>
            <ul class="lr-nav">
                <?php foreach ($mainCategory as $catParent): ?>
                    <?php $activeMenu = ''; ?>
                    <?php if ($catParent === reset($mainCategory)): ?>
                        <?php $activeMenu = 'active-menu'; ?>
                    <?php endif; ?>
                    <li id="<?php echo $catParent->name ?>" style="background-color:<?php echo $catParent->color ?>;" data="lr-tab" class="<?php echo $activeMenu ?>">
                        <span><?php echo $catParent->name ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php foreach ($mainCategory as $catParent): ?>
                <?php $active = ''; ?>
                <?php if ($catParent === reset($mainCategory)): ?>
                    <?php $active = 'active'; ?>
                <?php endif; ?>
                <section id="<?php echo $catParent->name ?>" class="<?php echo $active ?>">
                    <div class="lr-menu-cat">
                        <ul class="lr-sub-nav">
                            <?php $childCategory = LythRankingCore::getChildrenCategory($catParent->id_category); ?>
                            <?php if ($childCategory): ?>
                                <?php foreach ($childCategory as $child): ?>
                                    <?php $activeMenu = ''; ?>
                                    <?php if ($child === reset($childCategory)): ?>
                                        <?php $activeMenu = 'active-menu'; ?>
                                    <?php endif; ?>
                                    <li id="<?php echo $child->name ?>" style="background-color:<?php echo $child->color ?>;" data="lr-sub-tab" class="<?php echo $activeMenu ?>">
                                        <span><?php echo $child->name ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="lr-content">
                            <?php foreach ($childCategory as $child): ?>
                                <?php $active = ''; ?>
                                <?php if ($child === reset($childCategory)): ?>
                                    <?php $active = 'active'; ?>
                                <?php endif; ?>
                                <div id="<?php echo $child->name ?>" class="lr-sub-cat <?php echo $active ?>">
                                    <h3 class="lr-title-child-cat">Classement Brave exvius : <?php echo $child->name ?></h3>
                                    <?php $units = LythRankingCore::getListRankByCategory($child->id_category); ?>
                                    <?php if ($units): ?>
                                        <?php foreach ($units as $unit): ?>
                                            <div class="lr-unit">
                                                <div class="lr-title-unit">
                                                    <div class="lr-unit-rank">
                                                        <span># <?php echo $unit->unit_rank ?></span>
                                                    </div>
                                                    <div class="lr-unit-name">
                                                        <span><?php echo $unit->unit_name ?></span>
                                                    </div>
                                                    <div class="lr-url">
                                                        <?php if ($unit->url_post): ?>
                                                            <a href="<?php echo $unit->url_post ?>" target="_blank">Vidéo Analyse</a>
                                                        <?php else: ?>
                                                            <span>Vidéo Analyse</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="lr-unit-content">
                                                    <div class="lr-unit-image">
                                                        <?php $image_id = LythFrameCore::image_id_by_url($unit->image_url); ?>
                                                        <?php echo wp_get_attachment_image( $image_id, 'thumbnail'); ?>
                                                    </div>
                                                    <div class="lr-unit-details">
                                                        <div class="lr-details-positive">
                                                            <ul>
                                                                <?php $positiveDetails = maybe_unserialize($unit->positive_details); ?>
                                                                <?php if ($positiveDetails): ?>
                                                                    <?php foreach ($positiveDetails as $positiveRow): ?>
                                                                        <li><?php echo $positiveRow ?></li>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                        <div class="lr-details-negative">
                                                            <ul>
                                                                <?php $negativeDetails = maybe_unserialize($unit->negative_details); ?>
                                                                <?php if ($negativeDetails): ?>
                                                                    <?php foreach ($negativeDetails as $negativeRow): ?>
                                                                        <li><?php echo $negativeRow ?></li>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="lr-no-unit">Sorry, No unit in this catégory.</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
