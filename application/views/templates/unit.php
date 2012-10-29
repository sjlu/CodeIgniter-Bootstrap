<table width="100%" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th width="25%">Name</th>
         <th width="50%">Description</th>
         <th width="25%">Passed?</th>
      </tr>
   </thead>

   <?php foreach ($tests as $test): ?>
      <tr>
         <td><?php $test['Test Name']; ?></td>
         <td><?php $test['Notes']; ?></td>
         <td><span class="label <?php if ($test['Result'] == 'Passed'): ?>label-success<?php else: ?>label-important<?php endif; ?>"><?php $test['Result']; ?></span></td>
      </tr>
   <?php endforeach; ?>
</table>

<div class="row">
   <?php if ($failed > 0): ?>
      <div class="offset3 span5 alert alert-error" style="text-align: center;">
         <b>Not Good!</b> <?php $failed ?> of <?php $count ?> tests failed! 
   <?php else: ?>
      <div class="offset3 span5 alert alert-success" style="text-align: center;">
         <b>Success!</b> Of the <?php $count ?> tests ran, all of them passed!
   <?php endif; ?>
   </div>
</div>
