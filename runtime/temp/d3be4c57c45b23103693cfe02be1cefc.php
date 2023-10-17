<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\wamp64\www\shop\public/../application/index\view\common\head.htm";i:1690962791;}*/ ?>
<div class = "site-nav" id = "site-nav">
	<div class = "w w1390">
		<div class = "fl">


			<div class = "txt-info" id = "ECS_MEMBERZONE">
				<div class="scrollBody" id="scrollBody"></div>
			</div>
			<script type="text/javascript">
				$(function (){
					$.ajax({
						type: "GET",
						url:"<?php echo url('member/Account/checkLogin'); ?>",
						dataType: "json",
						success: function (data){
							if (data.error == 0){
								var html = "<span>您好 &nbsp;<a href='#'>"+data.username+"</a></span> <span>，欢迎来到&nbsp;<a alt='首页' title='首页' href='index.php'>陈某商场</a></span><span>[<a href='<?php echo url('member/User/loginOut'); ?>'>退出</a>]</span><div class='scrollBody' id='scrollBody'></div>";
								$('#ECS_MEMBERZONE').html(html);
							}else {
								var html ="<a href = '<?php echo url('member/account/login'); ?>'class = 'link-login red'>请登录</a> <a href = '<?php echo url('member/account/reg'); ?>' class = 'link-regist'>免费注册</a>";
								$('#ECS_MEMBERZONE').html(html);

							}
						}
					})
				});
			</script>
		</div>
		<ul class = "quick-menu fr">
			<?php if(is_array($navRes['top']) || $navRes['top'] instanceof \think\Collection || $navRes['top'] instanceof \think\Paginator): $i = 0; $__LIST__ = $navRes['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top_nav): $mod = ($i % 2 );++$i;?>
			<li>
				<div class = "dt"><a <?php if($top_nav['open'] == 1): ?> target="_blank" <?php endif; ?> href="<?php echo $top_nav['nav_url']; ?>"><?php echo $top_nav['nav_name']; ?></a></div>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>
<div class = "header">
	<div class = "w w1390">
		<div class = "logo">
			<div class = "logoImg"><a href = "#"><img src = "__index__/img/logo.png" /></a></div>
		</div>
		<div class = "dsc-search">
			<div class = "form">
				<form id="searchForm" name="searchForm" method="get" action="search.php" onsubmit="return checkSearchForm()" class="search-form">
					<input autocomplete="off" onkeyup="lookup(this.value);" name="keywords" id="keyword" value="<?php echo $configs['search_value']; ?>" class="search-text" type="text">
					<input name="store_search_cmt" value="0" type="hidden">
					<button type="submit" class="button button-goods" onclick="checkstore_search_cmt(0)">搜商品</button>
				</form>
				<ul class="keyword">
					<?php
					$arr=explode(',',$configs['search_keywords']);
					foreach($arr as $k  => $v):
										   ?>
					<li><a href="#"><?php echo $v;?></a></li>
					<?php endforeach?>
				</ul>

				<div class = "suggestions_box" id = "suggestions" style = "display:none;">
					<div class = "suggestions_list" id = "auto_suggestions_list">
						&nbsp;
					</div>
				</div>

			</div>
		</div>
		<div class = "shopCart" data-ectype = "dorpdown" id = "ECS_CARTINFO" data-carteveval = "0">

			<div class = "shopCart-con dsc-cm">
				<a href = "#">
					<i class = "iconfont icon-carts"></i>
					<span>我的购物车</span>
					<em class = "count cart_num">0</em>
				</a>
			</div>
			<div class = "dorpdown-layer" ectype = "dorpdownLayer">
				<div class = "prompt">
					<div class = "nogoods"><b></b><span>购物车中还没有商品，赶紧选购吧！</span></div>
				</div>
			</div>

			<script type = "text/javascript">
				//ajax异步获取顶级分类的子分类、品牌、频道等相关信息在右侧菜单的路径
				var ajax_cate_url="<?php echo url('Category/getCateInfo'); ?>";
				//在下拉菜单的加载中图片路径
				var load_img="__index__/img/loadGoods.gif";
				function changenum(rec_id, diff, warehouse_id, area_id) {
					var cValue = $('#cart_value').val();
					var goods_number = Number($('#goods_number_' + rec_id).text()) + Number(diff);

					if (goods_number < 1) {
						return false;
					} else {
						change_goods_number(rec_id, goods_number, warehouse_id, area_id, cValue);
					}
				}

				function change_goods_number(rec_id, goods_number, warehouse_id, area_id, cValue) {
					if (cValue != '' || cValue == 'undefined') {
						var cValue = $('#cart_value').val();
					}
					Ajax.call('flow.php?step=ajax_update_cart', 'rec_id=' + rec_id + '&goods_number=' + goods_number + '&cValue=' + cValue + '&warehouse_id=' + warehouse_id + '&area_id=' + area_id, change_goods_number_response, 'POST', 'JSON');
				}

				function change_goods_number_response(result) {
					var rec_id = result.rec_id;
					if (result.error == 0) {
						$('#goods_number_' + rec_id).val(result.goods_number);//更新数量
						$('#goods_subtotal_' + rec_id).html(result.goods_subtotal);//更新小计
						if (result.goods_number <= 0) {
							//数量为零则隐藏所在行
							$('#tr_goods_' + rec_id).style.display = 'none';
							$('#tr_goods_' + rec_id).innerHTML = '';
						}
						$('#total_desc').html(result.flow_info);//更新合计
						if ($('ECS_CARTINFO')) 

						if (result.group.length > 0) {
							for (var i = 0; i < result.group.length; i++) {
								$("#" + result.group[i].rec_group).html(result.group[i].rec_group_number);//配件商品数量
								$("#" + result.group[i].rec_group_talId).html(result.group[i].rec_group_subtotal);//配件商品金额
							}
						}

						$("#goods_price_" + rec_id).html(result.goods_price);
						$(".cart_num").html(result.subtotal_number);
					} else if (result.message != '') {
						$('#goods_number_' + rec_id).val(result.cart_Num);//更新数量
						alert(result.message);
					}
				}

				function deleteCartGoods(rec_id, index) {
					Ajax.call('delete_cart_goods.php', 'id=' + rec_id + '&index=' + index, deleteCartGoodsResponse, 'POST', 'JSON');
				}

				/**
				 * 接收返回的信息
				 */
				function deleteCartGoodsResponse(res) {
					if (res.error) {
						alert(res.err_msg);
					} else if (res.index == 1) {
						Ajax.call('get_ajax_content.php?act=get_content', 'data_type=cart_list', return_cart_list, 'POST', 'JSON');
					} else {
						$("#ECS_CARTINFO").html(res.content);
						$(".cart_num").html(res.cart_num);
					}
				}

				function return_cart_list(result) {
					$(".cart_num").html(result.cart_num);
					$(".pop_panel").html(result.content);
					tbplHeigth();
				}
			</script>
		</div>
	</div>
</div>
<div class = "nav dsc-zoom">
	<div class = "w <?php if(isset($show_right)){echo 'w1200'; }else{echo 'w1390'; }?>">
		<div class = "categorys <?php if(!isset($show_nav)){echo 'site-mast'; }?>">
			<div class = "categorys-type"><a href = "#" target = "_blank">全部商品分类</a></div>
			<div class = "categorys-tab-content">
				<div class = "categorys-items" id = "cata-nav">
<!--					菜单开始-->
					<?php if(is_array($cateRes) || $cateRes instanceof \think\Collection || $cateRes instanceof \think\Paginator): $i = 0; $__LIST__ = $cateRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
					<div class= "categorys-item" ectype = "cateItem" data-id = "<?php echo $cate['id']; ?>" data-eveval = "0">
						<div class= "item item-content">
							<i class= "iconfont <?php echo $cate['iconfont']; ?>"></i>
							<div class = "categorys-title">
								<strong>
									<a href = "#" target = "_blank"><?php echo $cate['cate_name']; ?></a><!--顶级类目-->
								</strong>
								<span><!--子类目-->
									<?php if(is_array($cate['chilrend']) || $cate['chilrend'] instanceof \think\Collection || $cate['chilrend'] instanceof \think\Paginator): $i = 0; $__LIST__ = $cate['chilrend'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son_cate): $mod = ($i % 2 );++$i;if($i < 3): ?><!-- lt 是小于,判断在菜单里面的子类里面 只会显示出前面两个子栏目-->
                        				<a href = "<?php echo url('index/Category/index',array('id'=>$son_cate['id'])); ?>" target = "_blank"><?php echo $son_cate['cate_name']; ?></a>
									  <?php endif; endforeach; endif; else: echo "" ;endif; ?>
								</span>
							</div>
						</div>
						<div class = "categorys-items-layer" ectype = "cateLayer">
							<div class = "cate-layer-con clearfix">
								<div class = "cate-layer-left">
									<div class = "cate_channel" ectype = "channels_<?php echo $cate['id']; ?>"></div>
									<div class = "cate_detail" ectype = "subitems_<?php echo $cate['id']; ?>"></div>


								</div>
								<div class = "cate-layer-rihgt" ectype = "brands_<?php echo $cate['id']; ?>"></div>



							</div>
						</div>
						<div class = "clear"></div>
					</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
<!--					菜单结束-->
				</div>
			</div>
		</div>
		<div class = "nav-main" id = "nav">
			<ul class = "navitems">
				<li><a href = "<?php echo url('index/Index/index'); ?>" class = "curr">首页</a></li>
				<?php if(is_array($navRes['mid']) || $navRes['mid'] instanceof \think\Collection || $navRes['mid'] instanceof \think\Paginator): $i = 0; $__LIST__ = $navRes['mid'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mid_nav): $mod = ($i % 2 );++$i;?>
				<li><a <?php if($mid_nav['open'] == 1): ?> target="_blank" <?php endif; ?> href="<?php echo $mid_nav['nav_url']; ?>"><?php echo $mid_nav['nav_name']; ?></a></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>