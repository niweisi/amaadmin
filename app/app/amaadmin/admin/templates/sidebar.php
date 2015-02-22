<!--<?php
defined('IN_MET') or exit('No permission');//保持入口文件，每个应用模板都要添加
echo <<<EOT
-->
<div class="vernav2 iconmenu ni">
	<ul>
<!--
EOT;
$i=1;
$mainUrl = '';
$icon = '';
foreach( $sidebarNav as $val ){
	if($i==1){ $mainUrl = $site_adminUrl.$val[$conturl].$anyid29; }
	
	$num = '';
	if( $this->feedbackNum > 0 && $val[module]==8 ){
		$num = $this->feedbackNum;
	}elseif( $this->messageNum > 0 && $val[module]==7 ){
		$num = $this->messageNum ;
	}
	if( $num>99 ){
    	$num = '...';
    }
	if( $num != '' ){ $num = '<b>'.$num.'</b>'; }
	//icon
	$icon = '';
	if($val[module]){
		$icon = 'module-'.$val[module];
	}else{
		$icon = 'id-'.$val[id];
	}
echo <<<EOT
-->
		<li class=""><a href="{$site_adminUrl}{$val[$conturl]}{$anyid29}" target="main" class="{$icon}">{$val[name]}{$icon} {$num}</a>
<!--
EOT;
if( $val[child]!='' ){//判断有没有子分类1
echo <<<EOT
-->
			<span class="arrow"><a href="#formsub_{$val[id]}"></a></span>
			<ul id="formsub_{$val[id]}">
<!--
EOT;
	foreach( $val[child] as $val2 ){//二级
		$num2 = '';
		if( $this->feedbackNum > 0 && $val2[module]==8 ){
			$num2 = $this->feedbackNum;
		}elseif( $this->messageNum > 0 && $val2[module]==7 ){
			$num2 = $this->messageNum ;
		}
		if( $num2>99 ){
    	$num2 = '...';
		}
		if( $num2 != '' ){ $num2 = '<b>'.$num2.'</b>'; }	
echo <<<EOT
-->
				
				<li><a href="{$site_adminUrl}{$val2[conturl]}{$anyid29}" target="main">{$val2[name]} {$num2}</a>
<!--
EOT;
if( $val2[child]!='' ){//判断有没有子分类2
echo <<<EOT
-->
					<span class="arrow"><a href="#formsub_{$val2[id]}"></a></span>
					<ul id="formsub_{$val2[id]}">
<!--
EOT;
		foreach( $val2[child] as $val3 ){//三级
			$num3 = '';
			if( $this->feedbackNum > 0 && $val3[module]==8 ){
				$num3 = $this->feedbackNum;
			}elseif( $this->messageNum > 0 && $val3[module]==7 ){
				$num3 = $this->messageNum ;
			}
			if( $num3>99 ){
				$num3 = '...';
			}
			if( $num3 != '' ){ $num3 = '<b>'.$num3.'</b>'; }
echo <<<EOT
-->
						<li><a href="{$site_adminUrl}{$val3[conturl]}{$anyid29}" target="main">{$val3[name]} {$num3}</a></li>
<!--
EOT;
		}//三级end
echo <<<EOT
-->                          
					</ul>
<!--
EOT;
}//判断有没有子分类2end
echo <<<EOT
-->	
				</li>
<!--
EOT;
	}//二级end
echo <<<EOT
-->	
			</ul>
<!--
EOT;
}//判断有没有子分类1end
echo <<<EOT
-->		
		</li>
<!--
EOT;
$i++;
}
echo <<<EOT
-->		
	</ul>
	<a class="togglemenu"></a>
	<br /><br />
</div><!--leftmenu-->
<!--
EOT;
?>