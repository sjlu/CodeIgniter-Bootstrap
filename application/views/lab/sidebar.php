<div class="well" style="padding: 8px 0;">
   <ul class="nav nav-list">
      <li class="nav-header">Actions</li>

      <li <? if(is_active('lab/intro')): ?>class="active"<? endif ?>><a href="<?= site_url('lab/intro/1') ?>">Introduction</a></li>
      <li <? if(is_active('lab/view')): ?>class="active"<? endif ?>><a href="<?= site_url('lab/view/1') ?>">Lab</a></li>
      <li <? if(is_active('lab/quiz')): ?>class="active"<? endif ?>><a href="<?= site_url('lab/quiz/1') ?>">Quiz</a></li>
   </ul>
</div>
