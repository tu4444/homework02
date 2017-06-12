<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/26
 * Time: 下午 02:09
 */

//組合資料的部分應寫在view.html.php裡面
$doc=JFactory::getDocument();
$doc->addScript(Juri::root().'/components/com_bliss/media/js/vue.js');

$app=JFactory::getApplication();
$app->setUserState('com_bliss.donations.items',[
	[
		'id'=>2,
		'price'=>'250'
	],
	[
		'id'=>1,
		'price'=>'300'
	]
]);

$items=(array) $app->getUserState('com_bliss.donations.items');

//print_r($items);


?>

<h1>donation hello</h1>

<div id="app">
	<div class="form-actions text-right">
		<button type="button" class="btn" v-on:click="addNewItem()">
			<span class="icon-plus"></span>
		</button>
	</div>
	<!--<ul class="nav">
		<li v-for="item in items">
			<label v-bind:for="getInputId(item)">{{item.id}}-{{item.title}}</label>
			<input id="getInputId(item)" type="text" v-model="item.price">
		</li>
	</ul>-->
	<table class="table table-bordered">
		<tr v-for="(item, k) in items">
			<td>
				<select v-bind:name="getInputName(k,'org_title')" id="" v-model="item.id">
					<option v-for="org in orgs" v-bind:value="org.id">{{org.title}}</option>
				</select>
			</td>
			<td>
				<input v-bind:name="getInputName(k,'price')" type="text" v-model="item.price">
			</td>
			<td>
				<button type="button" class="btn btn-small" v-on:click="removeItem(k)">
					<span class="icon-remove"></span>
				</button>
			</td>
		</tr>
	</table>

</div>

<script>
	var vm= new Vue({
		el:'#app',
		data:{
		    orgs:[
			    {id:'',title:'-----please select----'},
			    {id:1,title:'bliss'},
			    {id:2,title:'leezen'},
			    {id:3,title:'toaf'}
            ],
			items:<?php echo json_encode($items);?>
		},
		methods:{
            getInputId:function (item) {
				return 'input-'+ item.id;
            },
            getInputName:function(k,n){
                return 'orderitem['+k+']['+n+']';
            },
            addNewItem:function () {
	            return this.items.push({
		            id:'',
		            price:''
	            });
            },
            removeItem:function (k) {
                this.items.splice(k,1);
            }
		}

	});

</script>