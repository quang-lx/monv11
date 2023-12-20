<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <style>
         @font-face {
            font-family: 'NotoSansCondensedLight'; /* Choose a suitable font-family name */
            src: url('{{ public_path('fonts/NotoSans-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }


        body {
            /* font-family: 'NotoSansCondensedLight';  */
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: var(--Text-Tiu-1, #1C1C1E);
            font-feature-settings: 'clig' off, 'liga' off;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
            /* 166.667% */
        }

        .d-flex {
            display: flex
        }

        .float-left {
            float: left;
            width: 60%
        }

        .float-right {
            float: left;
            width: 40%
        }

        .clear {
            clear: both;
            margin: 0px 2px;
        }

        .table-bordered td,
        .table-bordered th {
            border: none
        }

        .table td,
        .table th {
            padding: 3px 15px;
            padding-bottom: 5px;
            vertical-align: middle !important;
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }

        .table-bordered {
            border: 1px solid #000;
        }
    </style>

<body>
    <div>
        <div>
            <div class="title float-left font-weight-bold" style="font-size: 14px;">
                Bác sĩ gia đình
            </div>
            <div class="patient_code float-right" style="text-align: right;">
                Mã bệnh nhân: {{ $patient->id }}
            </div>
        </div>
        <div class="clear"></div>

        <div
            style="text-align: center; font-size: 20px; font-weight: bold;text-transform: uppercase;margin-top: 25px; margin-bottom: 35px">
            Phiếu chỉ định
        </div>
        <div>
            <div class="font-weight-bold" style="font-size: 14px; margin-bottom: 8px;">
                Thông tin chung
            </div>
            <div class="float-left">
                <span class="label">Họ tên:</span>
                <span class="font-weight-bold">{{ $patient->name }}</span>
            </div>
            <div class="float-right">
                <span class="label">Giới tính:</span>
                <span>{{ $patient->sex == 1 ? 'Nam' : 'Nữ' }}</span>
            </div>
            <div class="clear"></div>
            <div class="float-left">
                <span class="label">Năm sinh:</span>
                <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $patient->birthday)->format('Y-m-d') }}</span>
            </div>
            <div class="float-right">
                <span class="label">Địa chỉ:</span>
                <span>{{ $patient->address }}</span>
            </div>
            <div class="clear"></div>

            <div class="float-left">
                <span class="label">Thời gian bắt đầu khám:</span>
                <span>20:00 20/02/2022</span>
            </div>
            <div class="float-right">
                <span class="label">Thời gian kết thúc khám:</span>
                <span>20:00 20/02/2022</span>
            </div>
            <div class="clear"></div>

            <div class="float-left">
                <span class="label">Thời gian chỉ định:</span>
                <span>20:00 20/02/2022</span>
            </div>
            <div class="float-right">
                <span class="label">Người chỉ định:</span>
                <span class="font-weight-bold">Hoàng Thu An (321312)</span>
            </div>
            <div class="clear"></div>

            <div class="float-left">
                <span class="label">Chẩn đoán:</span>
                <span>......................</span>
            </div>
            <div class="clear"></div>

        </div>
        <div>
            <div class="font-weight-bold" style="font-size: 14px; margin-top: 8px; margin-bottom: 20px;">
                Dịch vụ chỉ định
            </div>
        </div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Dịch vụ</th>
                        <th scope="col">Số lượng </th>
                        <th scope="col">Đơn giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $stt => $service)
                        <tr>
                            <th colspan="4" class="font-weight-bold" style="font-size: 12px">
                                {{ $service->testingService->name }}</th>
                        </tr>
                        @foreach ($service->listIndex as $key => $examinationIndex)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $examinationIndex->indexModel->name }}</td>
                                <td>{{ 1 }}</td>
                                <td>200.000</td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
        <div style="margin-top: 57px">
            <div class="float-left" style="width: 70%">
            </div>
            <div class="float-right" style="width: 30%">
                <span class="text-right">
                    ................., Ngày:....../....../2022
                </span>

                <div class="text-center font-weight-bold" style="margin-top: 16px; font-size: 14px">
                    Bác sĩ chỉ định
                </div>
                <div class="text-center">
                    (ký, ghi rõ họ tên)
                </div>

                <div class="text-center font-weight-bold" style="margin-top: 82px; font-size: 14px">
                    Hoàng Thu An
                </div>

            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>

</html>
