<fieldset>
	<legend><?php echo __('Menu'); ?></legend>
    <?php if(!empty($data)): ?>
    <?php //pr($data); ?>
    <ul>
        <?php $i = 0; ?>
        <?php $j = 0; ?>
        <?php foreach($data as $k => $item): ?>
        	<?php if(strpos($item,'||') === false): ?>
        		<?php $link = $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-cog text-success')),array('action' => 'add',$k),array('class' => "",'escape'=>false)); ?>
            	<?php $item = $item.' '.$link; ?>
        	<?php endif; ?>
        	<?php if(strpos($item,'|')!== false): ?>
        		<?php $link = $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit text-info')),array('action' => 'edit',$k),array('class' => "",'escape'=>false)); ?>
            	<?php $item = $item.' '.$link; ?>
				<?php $link = $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash text-danger')),array('action' => 'delete',$k),array('class' => "",'escape'=>false)); ?>
            	<?php $item = $item.' '.$link; ?>
        	<?php endif; ?>
            <?php if($i == 0): ?>
                <?php $data[$k] = '<li>'.$item ?>
                <?php $i = 1; ?>
            <?php else: ?>
                <?php if(strpos($item,'|')!== false): ?>
                    <?php if($i == 1 || $j+1==substr_count($item, '|') ): ?>                        
                        <?php $data[$k] = '<ul><li>'.$item ?>
                        <?php $j=substr_count($item, '|')?>
                        <?php $i = 2; ?>
                    <?php else: ?>
                    	<?php if($j>substr_count($item, '|') ): ?>
                    		 <?php $data[$k] = str_pad('</li><li>'.$item, strlen('</li><li>'.$item)+10*($j-1),'</li></ul>', STR_PAD_LEFT)  ?>
                    		 <?php $j=substr_count($item, '|')?>
                    	<?php else: ?>
                    		 <?php $data[$k] = '</li><li>'.$item ?>
                    	<?php endif; ?>                                          
                    <?php endif; ?>                    
                <?php else: ?>
                	<?php $data[$k] = str_pad('</li><li>'.$item, strlen('</li><li>'.$item)+10*$j,'</li></ul>', STR_PAD_LEFT)  ?>
                    <?php $i = 1;$j = 0; ?>
                <?php endif; ?>
            <?php endif; ?>    
        <?php endforeach; ?>
        <?php $data[$k] = str_pad($data[$k].'</li>', strlen($data[$k].'</li>')+10*$j,'</ul></li>',STR_PAD_RIGHT)  ?>
        <?php echo str_replace('|', '', implode('', $data)); ?>        
    </ul>
    <?php endif; ?>
</fieldset>
<br>
<br>
<?php foreach($data as $k => $item): ?>
<?php $data[$k] = htmlspecialchars($item); ?>
<?php endforeach; ?> 
<?php //pr($data); ?> 