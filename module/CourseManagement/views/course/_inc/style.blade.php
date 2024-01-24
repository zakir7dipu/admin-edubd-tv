<style>
    a {
        text-decoration: none !important;
    }

    input[readonly] {
        color: #000000;
        background: #dfdfdf !important;
    }

    .introduction, .outcome {
        display: flex !important; 
        align-items: center !important;
        margin-bottom: 10px !important;
    }

    .outcome {
        position: relative;
        margin-bottom: 20px !important;
    }

    .faq {
        position: relative;
        display: flex !important; 
        flex-direction: column;
        gap: 10px;
        align-items: center !important;
        margin-bottom: 20px !important;
        padding: 10px;
        background: #dfdfdf;
        box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
    }
    
    .topic, .lesson {
        position: relative;
        display: flex !important; 
        flex-direction: column;
        gap: 10px;
        align-items: center !important;
        margin-top: 5px;
        margin-bottom: 20px !important;
        padding: 10px;
        background: #eff6ff;
        box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
    }

    .introduction-label {
        width: 80px !important;
        height: 34px !important;
        background: #dfdfdf !important;
        padding: 7px !important;
        color: black !important;
        font-weight: 500 !important;
        text-align: center !important;
    }

    .outcome-label {
        max-height: 500px !important;
        color: black !important;
        font-weight: 500 !important;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px
    }

    .remove-btn {
        background: rgb(255, 170, 170) !important;
        border: 2px solid rgb(255, 170, 170) !important;
        color: rgb(255, 27, 27) !important;
        width: 36px !important;
        height: 34px !important;
        line-height: 30px !important;
        font-size: 15px !important;
    }

    .remove-icon {
        position: absolute; 
        top: -9px; 
        right: -9px; 
        font-size: 20px; 
        color: rgb(250, 85, 85); 
        background: white; 
        cursor: pointer;
        z-index: 9 !important;
        border-radius: 50%;
    }

    .remove-icon:hover {
        color: red;
    }

    .add-more {
        background: #79ffa5 !important;
        border: 2px solid #79ffa5 !important;
        color: black !important;
        height: 32px !important;
        line-height: 23px !important;
        font-size: 12px !important;
        border-radius: 5px !important;
    }

    .instructor {
        display: flex !important; 
        align-items: center !important;
        margin-bottom: 10px !important;
    }

    .instructor-image {
        z-index: 10 !important;
        margin-right: -4px !important;
        border-color: #AAA !important;
    }

    .panel-body {
        padding: 3px;
    }

    .panel-default>.panel-heading {
        /* display: flex;
        align-items: center;
        justify-content: space-between; */
        position: relative;
    }

    .accordion-style1.panel-group .panel-heading .accordion-toggle {
        padding: 15px 10px;
    }

    .accordion-style2.panel-group .panel-heading .accordion-toggle.collapsed {
        font-size: 15px;
        font-weight: 500;
        color: black;
    }

    .remove-lesson {
        position: absolute;
        right: 10px;
        top: 13px;
        font-size: 20px;
        color: red;
        cursor: pointer;
    }


    .upload-container {
        background: aliceblue;
        padding: 10px 20px;
        border-radius: 15px;
        box-shadow: rgba(33, 35, 38, 0.1) 0px 10px 10px -10px;
    }

    .video-link-div,
    .attachment-div {
        display: flex; 
        gap: 20px;
    }

    .btn-submit, .btn-submit:focus, .btn-submit:hover, .btn-submit:active, .btn-success:focus:hover {
    /* .btn-success[disabled], .btn-success[disabled]:hover { */
        background-color: #62f474 !important;
        border-color: #62f474 !important;
        color: #000000 !important;
    }

    .btn-submitting {
        display: none;
    }

    .btn-successed {
        display: none;
        background: #ffffff !important;
        border-color: #f7f7f7 !important;
        color: #004a22 !important;
        font-weight: 600;
    }

    .btn-failed {
        display: none;
        background: #ffffff !important;
        border-color: #f7f7f7 !important;
        color: #ab0000 !important;
        font-weight: 600;
    }

    .upload-in-google-drive-div {
        display: none;
        padding: 20px;
        background: #ffead7;
        text-align: center;
        border-radius: 15px;
    }
</style>