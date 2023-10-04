@extends('layouts.admin')

@section('admin_content')
    <div class="card custom mb-3">
        <div class="card-header rounded">
            <div class="card-title">
                Order Details
                <span class="ms-3 badge bg-white text-primary">
                    <i class="fa fa-user"></i>
                    {{ $order->User->name }}
                </span> |
                <span class="badge bg-white text-primary">
                    <i class="fa fa-clock-o"></i>
                    {{ dateTimeFormat($order->created_at) }}
                </span>
            </div>
            <a href="{{ route('orders.index') }}" class="btn btn-primary ms-3">
                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i>
                Go back
            </a>
        </div>
    </div>
    <div class="row g-3">
        @if (!is_null($customer))
            <div class="col-md-4">
                @if ($order->order_status == "3")
                    <div class="mb-3 alert alert-warning border border-warning shadow-sm" role="alert"> 
                        <strong class="text-dark">{{ $customer['first_name'] }} wants to Cancel the booking!</strong> Are you accept the Cancel Order Request?
                        @if($order->cancel_order_reason !== null) 
                            <div class="my-2"> 
                                <b>Reason for cancel : </b> {{ $order->cancel_order_reason }}
                            </div>
                        @endif
                        <div class="d-flex mt-2">
                            <form action="{{ route('orders.change-order-status',$order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="4" name="order_status">
                                <button type="submit" class="btn btn-sm btn-primary px-3">Accept</button> 
                            </form>
                            <form class="ms-2" action="{{ route('orders.change-order-status',$order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="5" name="order_status">
                                <button type="submit" class="btn btn-sm btn-danger px-3">Deny</button> 
                            </form>
                        </div>
                    </div> 
                @endif
                <div class="card border shadow-sm mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <label><b>Order Status</b></label>
                        <div> {!! OrderStatus($order->order_status) !!} </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.change-order-status',$order->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <select name="order_status" class="form-select">
                                    <option value="">-- set status --</option>
                                    <option {{ $order->order_status  == "0" ||  $order->order_status  == null  ? 'selected' : ''}} value="0">Pending</option>
                                    <option {{ $order->order_status == "1" ? 'selected' : '' }} value="1">Accepted</option>
                                    <option {{ $order->order_status == "2" ? 'selected' : '' }} value="2">Denied</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary px-3">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="header-title mb-3"><b>Billing Information</b></h6>
                        <table class="table">
                            <tr>
                                <th>First Name</th>
                                <td>{{ $customer['first_name'] }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $customer['last_name'] }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $customer['email'] }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $customer['phone_number'] }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $customer['address'] }}</td>
                            </tr>
                            <tr>
                                <th>City / Town</th>
                                <td>{{ $customer['city_town'] }}</td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>{{ $customer['state'] }}</td>
                            </tr>
                            <tr>
                                <th>Pin Code</th>
                                <td>{{ $customer['pin_code'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card border shadow-sm">
                    <div class="card-body">
                        <h6 class="header-title mb-3"><b>Order Information</b></h6>
                        <table class="table">
                            <tr>
                                <th>Razorpay Payment ID</th>
                                <td>{{ $order->payment_id }}</td>
                            </tr>
                            <tr>
                                <th>Razorpay Order ID</th>
                                <td>{{ $order->razorpay_order_id }}</td>
                            </tr>
                            <tr>
                                <th>Is Appoinment</th>
                                <td>{{ $order->appoinment == 1 ? "Yes" : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Appoinment Date & Time</th>
                                <td>{{ dateTimeFormat($order->datetime) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col">
            <div class="card border shadow-sm mb-3">
                <div class="card-body" style="height: 370px;overflow:auto">
                    <h6 class="header-title mb-3"><b>Items from Order</b></h6>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Test ID</th>
                                    <th>Dos Code</th>
                                    <th>Test Name</th>
                                    <th>Test Type</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_price = 0 @endphp
                                @foreach ($order->Tests as $key => $item)
                                    @php $total_price += (int) $item->TestPrice @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->TestId }}</td>
                                        <td>{{ $item->DosCode }}</td>
                                        <td>{{ $item->TestName }}</td>
                                        <td>{{ $item->IsPackage == 'Yes' ? 'Test Packages' : 'Lab Test' }}</td>
                                        <td>{{ $item->TestPrice }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card border shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span style="font-size: 16px" class="me-2  badge-{{ $order->payment_status == 1 ? 'success' : 'danger' }}">
                            <i class="fa {{ $order->payment_status == 1 ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            {{ $order->payment_status == 1 ? 'Payment Success' : 'Payment Failed' }}
                        </span>
                    </div>
                    <div>
                        Total Price  : <b>₹ {{ $total_price }}</b>
                    </div>
                </div>
            </div>

            <div class="card border shadow-sm">
                <div class="card-body">
                    <h6 class="header-title mb-3"><b>Razorpay Information</b></h6>
                    <table class="table">
                        @foreach (unserialize($order->order_response)->toArray() as $key =>  $item)
                            <tr>
                                
                                @if (!is_null($item) && $key !== 'notes' && $key !== 'created_at')
                                @if($key=='offers' && is_array($item))
                                <th>{{ textFormat($key) }}</th>
                                @php
                                    $pp=[];
                                    foreach($item as $data){
                                    $pp[]=$data;
                                    }
                                   
                                @endphp
                                 <td>{{ implode(",",$pp) }}</td>
                                    @else
                                    <td>{{ $item}}</td>
                                    @endif
                                    @elseif ($key == 'created_at')
                                     
                                        <th>{{ textFormat($key) }}</th>
                                        <td>{{ dateFormat($item) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
