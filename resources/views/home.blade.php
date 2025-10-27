@extends ('layouts.app')
@section('tittle','Trang chủ')
@section('content')
<div class="row">
   <div class="col-md-12 col-lg-12">
      <div class="row row-cols-1">
         <div class="overflow-hidden d-slider1 ">
            <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
               <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                  <div class="card-body">
                     <div class="progress-widget">
                        <div id="circle-progress-01" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="10" data-type="percent">
                           <svg class="card-slie-arrow icon-24" width="24"  viewBox="0 0 24 24">
                              <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                           </svg>
                        </div>
                        <div class="progress-detail">
                           <p  class="mb-2">Số học sinh chờ đón</p>
                           <h4 class="counter">134</h4>
                        </div>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                  <div class="card-body">
                     <div class="progress-widget">
                        <div id="circle-progress-02" class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                           <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                              <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                           </svg>
                        </div>
                        <div class="progress-detail">
                           <p  class="mb-2">Số học sinh đang di chuyển</p>
                           <h4 class="counter">200</h4>
                        </div>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                  <div class="card-body">
                     <div class="progress-widget">
                        <div id="circle-progress-03" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                           <svg class="card-slie-arrow icon-24" width="24" viewBox="0 0 24 24">
                              <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                           </svg>
                        </div>
                        <div class="progress-detail">
                           <p  class="mb-2">Số học sinh đã đến nơi</p>
                           <h4 class="counter">100</h4>
                        </div>
                     </div>
                  </div>
               </li>
            </ul>
            <div class="swiper-button swiper-button-next"></div>
            <div class="swiper-button swiper-button-prev"></div>
         </div>
      </div>
   </div>
   <div class="col-md-12 col-lg-8">
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-12 col-lg-12">
            <div class="overflow-hidden card" data-aos="fade-up" data-aos-delay="600">
               
               <div class="p-0 card-body">
                  <div class="mt-4 table-responsive">
                     <table id="basic-table" class="table mb-0 table-striped" role="grid">
                        <thead>
                           <tr>
                              <th>XE</th>
                              <th>TÀI XẾ</th>
                              <th>TUYẾN ĐƯỜNG</th>
                              <th>ĐÓN</th>
                              <th>TRẢ</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <h6>XE001</h6>
                                 </div>
                              </td>
                              <td>
                                 <div class="iq-media-group iq-media-group-1">
                                    <a href="#" class="iq-media-1">
                                       <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                    </a>
                                 </div>
                              </td>
                              <td>Quận 1 - Quận 2 - Quận 5</td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>60%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>0%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <h6>XE001</h6>
                                 </div>
                              </td>
                              <td>
                                 <div class="iq-media-group iq-media-group-1">
                                    <a href="#" class="iq-media-1">
                                       <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                    </a>
                                 </div>
                              </td>
                              <td>Quận 1 - Quận 2 - Quận 5</td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>60%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>0%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <h6>XE001</h6>
                                 </div>
                              </td>
                              <td>
                                 <div class="iq-media-group iq-media-group-1">
                                    <a href="#" class="iq-media-1">
                                       <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                    </a>
                                 </div>
                              </td>
                              <td>Quận 1 - Quận 2 - Quận 5</td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>60%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>0%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <h6>XE001</h6>
                                 </div>
                              </td>
                              <td>
                                 <div class="iq-media-group iq-media-group-1">
                                    <a href="#" class="iq-media-1">
                                       <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                    </a>
                                 </div>
                              </td>
                              <td>Quận 1 - Quận 2 - Quận 5</td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>60%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                              <td>
                                 <div class="mb-2 d-flex align-items-center">
                                    <h6>0%</h6>
                                 </div>
                                 <div class="shadow-none progress bg-soft-primary w-100" style="height: 4px">
                                    <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </td>
                           </tr>
                           
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
            <div class="card" data-aos="fade-up" data-aos-delay="800">
               <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                  <div class="header-title">
                     <h4 class="card-title">53</h4>
                     <p class="mb-0">Người dùng mới</p>          
                  </div>
                  <div class="d-flex align-items-center align-self-center">
                     <div class="d-flex align-items-center text-primary">
                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                           <g>
                              <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                           </g>
                        </svg>
                        <div class="ms-2">
                           <span class="text-gray">Học sinh</span>
                        </div>
                     </div>
                     <div class="d-flex align-items-center ms-3 text-info">
                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                           <g>
                              <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                           </g>
                        </svg>
                        <div class="ms-2">
                           <span class="text-gray">Tài xế</span>
                        </div>
                     </div>
                  </div>
                  <div class="dropdown">
                     <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButton22" data-bs-toggle="dropdown" aria-expanded="false">
                     Tuần
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton22">
                        <li><a class="dropdown-item" href="#">Tuần</a></li>
                        <li><a class="dropdown-item" href="#">Tháng</a></li>
                        <li><a class="dropdown-item" href="#">Năm</a></li>
                     </ul>
                  </div>
               </div>
               <div class="card-body">
                  <div id="d-main" class="d-main"></div>
               </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="1000">
               <div class="flex-wrap card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Số học sinh ở các quận</h4>            
                  </div>
               </div>
               <div class="card-body">
                  <div id="d-activity" class="d-activity"></div>
               </div>
            </div>
         </div>        
         
      </div>
   </div>
   <div class="col-md-12 col-lg-4">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="card" data-aos="fade-up" data-aos-delay="500">
               <div class="text-center card-body d-flex justify-content-around">
                  <div>
                     <h2 class="mb-2">20</h2>
                     <p class="mb-0 text-gray">Tài xế</p>
                  </div>
                  <hr class="hr-vertial">
                  <div>
                     <h2 class="mb-2">598</h2>
                     <p class="mb-0 text-gray">Học sinh</p>
                  </div>
               </div>
            </div> 
         </div>
         <div class="col-md-12 col-lg-12">
            <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Hoạt động tổng quan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start align-items-center m-2" >
                            <div>
                                <h6 class="mb-1">XE001 đã bắt đầu chuyến đi sáng</h6>
                                <p class="mb-0">07:00 12/06/2025</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center m-2" >
                            <div>
                                <h6 class="mb-1">XE002 đã bắt đầu chuyến đi sáng</h6>
                                <p class="mb-0">07:00 12/06/2025</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center m-2" >
                            <div>
                                <h6 class="mb-1">XE003 đã bắt đầu chuyến đi sáng</h6>
                                <p class="mb-0">07:00 12/06/2025</p>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
      </div>
   </div> 
</div>
@endsection