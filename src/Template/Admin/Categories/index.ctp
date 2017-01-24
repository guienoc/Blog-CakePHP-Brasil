<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categories index large-9 medium-8 columns content">
    <h3><?= __('Categories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $id => $category): ?>
            <tr>
                <td><?= $category ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $id]) ?>
                    <?= $this->Form->postLink(__('Move down'), ['action' => 'moveDown', $id], ['confirm' => __('Are you sure you want to move down # {0}?', $id)]) ?>
                    <?= $this->Form->postLink(__('Move up'), ['action' => 'moveUp', $id], ['confirm' => __('Are you sure you want to move up # {0}?', $id)]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $id], ['confirm' => __('Are you sure you want to delete # {0}?', $id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
