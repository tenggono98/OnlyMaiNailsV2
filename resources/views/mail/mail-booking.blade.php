<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>

<style>
    /* -------------------------------------
    GLOBAL RESETS
------------------------------------- */

/*All the styling goes here*/

img {
  border: none;
  -ms-interpolation-mode: bicubic;
  max-width: 100%;
}

body {
  background-color: #eaebed;
  font-family: sans-serif;
  -webkit-font-smoothing: antialiased;
  font-size: 14px;
  line-height: 1.4;
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}

table {
  border-collapse: separate;
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
  min-width: 100%;
  width: 100%; }
  table td {
    font-family: sans-serif;
    font-size: 14px;
    vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */

.body {
  background-color: #eaebed;
  width: 100%;
}

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
  display: block;
  Margin: 0 auto !important;
  /* makes it centered */
  max-width: 580px;
  padding: 10px;
  width: 580px;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
  box-sizing: border-box;
  display: block;
  Margin: 0 auto;
  max-width: 580px;
  padding: 10px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
  background: #ffffff;
  border-radius: 3px;
  width: 100%;
}

.header {
  padding: 20px 0;
}

.wrapper {
  box-sizing: border-box;
  padding: 20px;
}

.content-block {
  padding-bottom: 10px;
  padding-top: 10px;
}

.footer {
  clear: both;
  Margin-top: 10px;
  text-align: center;
  width: 100%;
}
  .footer td,
  .footer p,
  .footer span,
  .footer a {
    color: #9a9ea6;
    font-size: 12px;
    text-align: center;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1,
h2,
h3,
h4 {
  color: #06090f;
  font-family: sans-serif;
  font-weight: 400;
  line-height: 1.4;
  margin: 0;
  margin-bottom: 30px;
}

h1 {
  font-size: 35px;
  font-weight: 300;
  text-align: center;
  text-transform: capitalize;
}

p,
ul,
ol {
  font-family: sans-serif;
  font-size: 14px;
  font-weight: normal;
  margin: 0;
  margin-bottom: 15px;
}
  p li,
  ul li,
  ol li {
    list-style-position: inside;
    margin-left: 5px;
}

a {
  color: #ec0867;
  text-decoration: underline;
}

/* -------------------------------------
    BUTTONS
------------------------------------- */
.btn {
  box-sizing: border-box;
  width: 100%; }
  .btn > tbody > tr > td {
    padding-bottom: 15px; }
  .btn table {
    min-width: auto;
    width: auto;
}
  .btn table td {
    background-color: #ffffff;
    border-radius: 5px;
    text-align: center;
}
  .btn a {
    background-color: #ffffff;
    border: solid 1px #ec0867;
    border-radius: 5px;
    box-sizing: border-box;
    color: #ec0867;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    margin: 0;
    padding: 12px 25px;
    text-decoration: none;
    text-transform: capitalize;
}

.btn-primary table td {
  background-color: #ec0867;
}

.btn-primary a {
  background-color: #ec0867;
  border-color: #ec0867;
  color: #ffffff;
}

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
  margin-bottom: 0;
}

.first {
  margin-top: 0;
}

.align-center {
  text-align: center;
}

.align-right {
  text-align: right;
}

.align-left {
  text-align: left;
}

.clear {
  clear: both;
}

.mt0 {
  margin-top: 0;
}

.mb0 {
  margin-bottom: 0;
}

.preheader {
  color: transparent;
  display: none;
  height: 0;
  max-height: 0;
  max-width: 0;
  opacity: 0;
  overflow: hidden;
  mso-hide: all;
  visibility: hidden;
  width: 0;
}

.powered-by a {
  text-decoration: none;
}

hr {
  border: 0;
  border-bottom: 1px solid #f6f6f6;
  Margin: 20px 0;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 620px) {
  table[class=body] h1 {
    font-size: 28px !important;
    margin-bottom: 10px !important;
  }
  table[class=body] p,
  table[class=body] ul,
  table[class=body] ol,
  table[class=body] td,
  table[class=body] span,
  table[class=body] a {
    font-size: 16px !important;
  }
  table[class=body] .wrapper,
  table[class=body] .article {
    padding: 10px !important;
  }
  table[class=body] .content {
    padding: 0 !important;
  }
  table[class=body] .container {
    padding: 0 !important;
    width: 100% !important;
  }
  table[class=body] .main {
    border-left-width: 0 !important;
    border-radius: 0 !important;
    border-right-width: 0 !important;
  }
  table[class=body] .btn table {
    width: 100% !important;
  }
  table[class=body] .btn a {
    width: 100% !important;
  }
  table[class=body] .img-responsive {
    height: auto !important;
    max-width: 100% !important;
    width: auto !important;
  }
}

/* -------------------------------------
    PRESERVE THESE STYLES IN THE HEAD
------------------------------------- */
@media all {
  .ExternalClass {
    width: 100%;
  }
  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div {
    line-height: 100%;
  }
  .apple-link a {
    color: inherit !important;
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    text-decoration: none !important;
  }
  .btn-primary table td:hover {
    background-color: #d5075d !important;
  }
  .btn-primary a:hover {
    background-color: #d5075d !important;
    border-color: #d5075d !important;
  }
}
</style>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f3f4f6;">
    <div style="position: relative; display: flex; min-height: 100vh; flex-direction: column; justify-content: center; overflow: hidden; padding-top: 1.5rem; padding-bottom: 3rem;">
        <div style="position: relative; background-color: white; padding: 2rem 1.5rem; box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -2px rgba(0, 0, 0, 0.05); border-radius: 0.5rem; max-width: 42rem; margin: auto;">
            <table style="max-width: 48rem; margin-left: auto; margin-right: auto;">
                <tbody>
                    <tr>
                        <td>
                            <img src="https://onlymainails.alfonso-tenggono.online/img/transparant-logo.png" style="height:10.5rem;" alt="OnlyMaiNails Logo" />
                        </td>
                        <td>
                            <p style="margin-bottom: 0; font-weight: bold;">OnlyMaiNails</p>
                            <small style="display: block; margin-bottom: 0.5rem;">Atelier House - 5885 Victoria Drive, Vancouver</small>
                            <small style="display: block;">Email: maixesthetics@gmail.com</small>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="padding-bottom: 2rem; text-align: left; color: #4b5563; line-height: 1.75;">
               <table style="width: 100%;padding-left:50px">
                        <tbody>
                            <tr>
                                <td style="width: 40px;">
                                    <img src="https://img.icons8.com/?size=100&id=86305&format=png&color=000000" style="width: 1.5rem; height: 1.5rem;" alt="">
                                </td>
                                <td>
                                    <p style='margin:0;padding:0;'>Appointment Schedule for</p>
                                    <p style="font-weight: bold; margin:0;padding:0;">Alfonso Tenggono</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px;">
                                    <img src="https://img.icons8.com/?size=100&id=42763&format=png&color=000000" style="width: 1.5rem; height: 1.5rem; margin-right: 1rem;" alt="">
                                </td>
                                <td>
                                    <p style='margin:0;padding:0;'>Service</p>
                                    <ul style="list-style-type: none; padding-left: 0;margin:0;padding:0;">
                                        <li style="font-weight: bold;margin:0;padding:0;">(Gel-X) Medium Set</li>
                                        <li style="font-weight: bold;margin:0;padding:0;">(Other Services) Basic Gel Manicure</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px;">
                                    <img src="https://img.icons8.com/?size=100&id=UTe6yKq2hvHK&format=png&color=000000" style="width: 1.5rem; height: 1.5rem; margin-right: 1rem;" alt="">
                                </td>
                                <td>
                                    <p style='margin:0;padding:0;'>Date & Time</p>
                                    <p style="font-weight: bold;margin:0;padding:0;">Sunday, 20 January 2024</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40px;">
                                    <img src="https://img.icons8.com/?size=100&id=11676&format=png&color=000000" style="width: 1.5rem; height: 1.5rem; margin-right: 1rem;" alt="">
                                </td>
                                <td>
                                    <p style='margin:0;padding:0;'>Reschedule or Cancel Appointment</p>
                                    <p style="font-weight: bold; margin-left: 2.5rem;margin:0;padding:0;"><a href="#" style="font-weight: bold;">Click Here</a></p>
                                    <p style="margin-left: 2.5rem;margin:0;padding:0;">URL</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <p style="margin-top: 1.5rem; font-size: 0.875rem;">We've attached a little guide, with more details about our services and tips to make the most of your visit. We hope you find it helpful!</p>
            </div>
        </div>
    </div>
</body>

</html>
