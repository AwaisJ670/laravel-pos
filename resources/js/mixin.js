import Vue from "vue";
import moment from "moment";
import ExcelJS from 'exceljs';

Vue.mixin({
    data() {
        return {

        };
    },
    computed:{
        ResultNotFound(){
            if(this.loading == false && this.data.length === 0){
                return "No Record Found";
            }
            else{
                return ""
            }
        }
    },
    methods: {
        successToast(text) {
            this.$swal.fire({
                toast: true,
                position: "top-right",
                icon: "success",
                text: text,
                showConfirmButton: false,
                customClass: {
                    container: "sweet-toast-custom-success"
                },
                timer: 2000
            });
            $("body").removeClass("swal2-height-auto");
        },
        infoToast(text) {
            this.$swal.fire({
                toast: true,
                position: "top-right",
                icon: "info",
                text: text,
                showConfirmButton: false,
                customClass: {
                    container: "sweet-toast-custom-success"
                },
                timer: 2000
            });
            $("body").removeClass("swal2-height-auto");
        },
        errorToast(text) {
            this.$swal.fire({
                toast: true,
                position: "top-right",
                icon: "error",
                text: text,
                showConfirmButton: false,
                customClass: {
                    container: "sweet-toast-custom-error"
                },
                timer: 2000
            });
            $("body").removeClass("swal2-height-auto");
        },
        successAlert(text) {
            this.$swal.fire({
                icon: "success",
                text: text,
                showConfirmButton: false,
                timer: 3000
            });
            $("body").removeClass("swal2-height-auto");
        },
        errorAlert(text) {
            this.$swal.fire({
                icon: "error",
                text: text,
                showConfirmButton: false,
                timer: 3000
            });
            $("body").removeClass("swal2-height-auto");
        },
        successAlertWithoutText() {
            this.$swal.fire({
                position: "top",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            });
            $("body").removeClass("swal2-height-auto");
        },
        errorAlertWithoutText() {
            this.$swal.fire({
                position: "top",
                icon: "error",
                showConfirmButton: false,
                timer: 3000
            });
            $("body").removeClass("swal2-height-auto");
        },
        deleteConfirmationAlert(url, callback) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios({
                            url: url,
                            method: "DELETE"
                        })
                            .then(response => {
                                if (response.status === 200) {
                                    return response.data.message;
                                } else {
                                    return new Error(response.statusText);
                                }
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                );
                            });
                    }
                })
                .then(result => {
                    if (result.isConfirmed) {
                        this.$swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: result.value
                        });
                        if (callback && typeof callback === 'function') {
                            callback(); // Execute the callback function
                        }
                    }
                });
        },
        dateTimeFormatAMPMMethod(date) {
            if (date) return moment(date).format("DD-MM-YYYY LT");
        },
        // get difference between dateTime
        diffHoursBetweenDateTime(start, end) {
            if (start && end) {
                let startDateTime = moment(start, "YYYY-MM-DD hh:mm:ss");
                let endDateTime = moment(end, "YYYY-MM-DD hh:mm:ss");
                let duration = moment.duration(endDateTime.diff(startDateTime));

                return (
                    duration._data.hours +
                    " Hours " +
                    duration._data.minutes +
                    " Minute"
                );
            }
        },
        async generateExcelSheet(
            data,
            headers,
            filename,
        ) {
            // console.log(data,headers,filename);
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet("Sheet1");

            // Set headers row
            const headerRow = worksheet.addRow(headers);

            // Set default column widths based on header lengths
            const columnWidths = headers.map((header) => ({
                header: header,
                key: header,
                width: header.length + 10, // Add some extra space for padding
            }));
            worksheet.columns = columnWidths;

            headerRow.eachCell((cell, colNumber) => {
                if (colNumber !== 1) {
                    cell.style = {
                        fill: {
                            type: "pattern",
                            pattern: "solid",
                            fgColor: { argb: "FF000080" }, // Blue color
                        },
                        font: {
                            bold: true,
                            color: { argb: "FFFFFFFF" }, // White font color
                        },
                    };
                }
            });

            worksheet.addRow([]);

            // Add data rows
            data.forEach((obj) => {
                const rowValues = headers.map((header) => obj[header]);
                const row = worksheet.addRow(rowValues); // Create a row here

            });
            // Create a Blob for the Excel file
            const excelBlob = await workbook.xlsx.writeBuffer();
            const blobUrl = URL.createObjectURL(new Blob([excelBlob]));

            // Create a temporary anchor to trigger download
            const a = document.createElement("a");
            a.style.display = "none";
            a.href = blobUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        },
    },
    filters: {
        dateTimeFormatAMPM(date) {
            if (date) return moment(date).format("DD-MM-YYYY LT");
        },
        dateFormat(date) {
            if (date) return moment(date).format("DD-MM-YYYY");
        },
        dateTimeFormat(date) {
            if (date) return moment(date).format("DD-MM-YYYY hh:mm A");
        },
        unixToDateTimeAMPM(date) {
            if (date) return moment(date * 1000).format("DD-MM-YYYY LT");
        },
        stringToIntegerThousandsSeparator(number) {
            if (number) {
                let stringToInteger = parseFloat(number);
                return stringToInteger.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        },
        stringToIntegerThousandsSeparatorButNoDecimal(number) {
            if (number) {
                let stringToInteger = parseFloat(number);
                return stringToInteger.toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        },
        thousandsSeparator(number) {
            return number.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }
});
