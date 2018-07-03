@extends('../layouts.dash_layout')

@section('required_css')
	<link rel="stylesheet" href="{{asset('_vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('_vendor/DataTables/css/DT_bootstrap.css')}}">
@endsection

@section('content')
		 

		  @if( $staff_dept_collection->isEmpty())
				<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="alert-heading margin-bottom-10"><i class="ti-close"></i> Error!</h4>
					<p class="margin-bottom-10">
						No Staff Department Created
					</p>

				</div>
		  @else
			<!--  Begin Initial -->
			<div id="initial" class="init">
				 <h5 class="over-title" style="margin-top:29px !important"><span class="text-bold badge badge-success "> <?php echo $staff_dept_collection->count() ?></span> staff departments(s) created! </h5>

						<table class="table table-striped table-bordered table-hover table-full-width sample_1">
										<thead>
											<tr>
												<th>  </th>
												<th class="center">Department Name</th>
											</tr>
										</thead>
										<tbody>

										
											
											@foreach($staff_dept_collection as $val)
											
											<tr data-id="{{ $val->dept_id }}">
												<td style="width: 30px">
											@if(Route::current()->getName() == 'edit_staff_dept')
											<i data-action="edit" style="cursor: pointer" class="ti-pencil-alt" data-placement="right" data-toggle="tooltip" data-original-title="Edit {{ $val->dept_name }}"></i>
													
											@else
											 {{ $val->dept_id }}		
											@endif
																									
												</td>
												<td class="center">{{ $val->dept_name }}</td>
												
											</tr>
										
											@endforeach
										</tbody>
									</table>
						<span class="clearfix"></span>

			</div>		           
			<!--  End of Initial -->	

               <!-- Right Aside -->
               @if(Route::current()->getName() == 'edit_staff_dept')
					<div class="modal fade modal-aside horizontal right edit_area"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="myModalLabel">Edit Staff Department</h4>
								</div>
								<div class="modal-body">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
										Close
									</button>

								</div>
							</div>
						</div>
					</div>
                  @endif
					<!-- /Right Aside -->

	        
          @endif


@endsection

@section('required_js')
    <script src="{{asset('js/main.js')}}"></script>
	<script src="{{asset('_vendor/DataTables/jquery.dataTables.min.js')}}"></script>
    <script>
			jQuery(document).ready(function() {
				Main.init();
			});
	</script>
@endsection

@section('additional_js')
    <script>
	 //Reset all checkboxes
	 $("input[type=checkbox]").removeAttr("checked");
		
	//Activate Data Tables
	   var oTable = $('.sample_1').dataTable({
			"aoColumnDefs" : [{
				"aTargets" : [0]
			}],
			"oLanguage" : {
				"sLengthMenu" : "Show _MENU_ Rows",
				"sSearch" : "",
				"oPaginate" : {
					"sPrevious" : "",
					"sNext" : ""
				}
			},
			"aaSorting" : [[0, 'asc']],
			"aLengthMenu" : [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
			],
			// set the initial value
			"iDisplayLength" : 30,
		});
		$('.sample_1_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search Staff");
		// modify table search input
		$('.sample_1_wrapper .dataTables_length select').addClass("m-wrap small");
		// modify table per page dropdown
		// initialzie select2 dropdown
		$('.sample_1_column_toggler input[type="checkbox"]').change(function() {
			/* Get the DataTables object again - this is not a recreation, just a get of the object */
			var iCol = parseInt($(this).attr("data-column"));
			var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
			oTable.fnSetColumnVis(iCol, ( bVis ? false : true));
		});
		
	@if(Route::current()->getName() == 'edit_staff_dept')
				
		$('tbody').on('click','i[data-action]',function(e)
				{
					e.preventDefault();
					var action=$(this).data("action");
					var no=$(this).closest('tr').data("id");
					var toks=$("input[name='_token']").val();
					
					switch(action){
					case "edit":
						 $.ajax(
								 {
									 type:"POST",
									 data:{id:no,_token:toks},
									 url:"{{route('get_edit_staff_dept')}}",
									 beforeSend:function()
									  {
										  $('table').block({ message: null }); 
									  },
									  success: function(r)
									  {							  
										 $('table').unblock(); 
										  $('div.modal-body').html(r);
										   $('.edit_area').modal({
												backdrop: 'static',
												keyboard: false
											})

									
									  }
								 }
				 
						     );
							break;
					}
		      });
		
		@endif		
		
	</script>
@endsection