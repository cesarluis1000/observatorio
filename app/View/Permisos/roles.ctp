<fieldset>
	<legend><?php echo __('Accesos'); ?></legend>
    <?php if(!empty($data)): ?>
    <ul>
        <?php $i = 0; ?>
        <?php $j = 0; ?>
        <?php //pr($data); ?>
        <?php foreach($data as $k => $item): ?>
            <?php if($i == 0): ?>
                <?php $data[$k] = '<li>'.$item ?>
                <?php $i = 1; ?>
            <?php else: ?>
                <?php if(strpos($item,'|')!== false): ?>
                	<!-- Link para permisos -->
                    <?php $a_ids = explode('|', $k) ?>
                    <?php if(strpos($item,'-1')!== false): ?>
                        <?php $link = $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-remove text-danger')),array('action' => 'acceso',1,$a_ids[0],end($a_ids)),array('class' => "",'escape'=>false)); ?>
            			<?php $item = str_replace('-1',$link , $item); ?>
            		<?php else: ?>
            			<?php $link = $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-ok text-success')),array('action' => 'acceso',0,$a_ids[0],end($a_ids)),array('class' => "",'escape'=>false)); ?>
            			<?php $item = str_replace('1',$link , $item); ?>
        			<?php endif; ?>
        			<!-- find Link para permisos -->
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
        
          
          	<?php foreach ($data as $item): ?>
            	<?php //echo htmlentities($item); ?> 
             <?php endforeach; ?>	
          
            
        <?php $data = str_replace('|', '', implode('', $data)); ?>
       
        <?php echo $data; ?> 
    </ul>
    <?php endif; ?>
</fieldset>