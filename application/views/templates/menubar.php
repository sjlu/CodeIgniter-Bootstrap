<div class="subnav" style="margin-bottom: 10px;">
   <ul class="nav nav-pills">
      <li <? if(is_active()): ?>class="active"<? endif; ?>><a href="<?= site_url() ?>">Home</a></li>
      <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
         <ul class="dropdown-menu">
               <li><a href="">Item</a></li>
         </ul>
      </li> 
      <ul class="nav nav-pills pull-right">
         <li><a href="">Right</a></li>
      </ul>
   </ul>
</div>
