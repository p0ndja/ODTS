<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 92vh;">
        <div class="col-12 col-md-6">
            <ul class="nav nav-tabs nav-justified md-tabs bg-pharm" id="myTabMD" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="HNSearch_nav" data-toggle="tab" href="#HNSearch" role="tab"
                        aria-controls="HNSearch" aria-selected="true">ค้นหาโดยใช้รหัสประจำตัวผู้ป่วย</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="DocIDSearch_nav" data-toggle="tab" href="#DocIDSearch" role="tab"
                        aria-controls="DocIDSearch" aria-selected="false">ค้นหาโดยใช้รหัสประจำเอกสาร</a>
                </li>
            </ul>
            <div class="tab-content card pt-5" id="myTabContentMD">
                <div class="tab-pane fade show active" id="HNSearch" role="tabpanel" aria-labelledby="HNSearch">
                    <form method="post" action="#HNSearch">
                        <div class="mb-3">
                            <div class="button-box">
                                <label for="exampleInput" class="fw-bold"></label>
                                <input type="text" class="form-control form-control-lg" id="HNSearchField"
                                    name="HNSearchField" placeholder="ค้นหาโดยใช้เลขประจำตัวผู้ป่วย (HN)"
                                    style="text-align:center">
                                <div class="text-center mt-3"><button type="submit" name="method" value="HN" class="btn btn-rounded btn-success"><i class="fas fa-search"></i> ค้นหา</button></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="DocIDSearch" role="tabpanel" aria-labelledby="DocIDSearch">
                    <form method="post" action="#DocIDSearch">
                        <div class="mb-3">
                            <div class="button-box">
                                <label for="exampleInput" class="fw-bold"></label>
                                <input type="text" class="form-control form-control-lg" id="DocIDSearchField"
                                    name="DocIDSearchField" placeholder="ค้นหาโดยใช้เลขประจำเอกสาร"
                                    style="text-align:center">
                                <div class="text-center mt-3"><button type="submit" name="method" value="DOC" class="btn btn-rounded btn-success"><i class="fas fa-search"></i> ค้นหา</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>