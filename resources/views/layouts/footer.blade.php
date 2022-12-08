<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="sc-inner">
            <div class="footer-info">
                <div class="footer-detail">
                    <a href="#"><img alt="Footer Logo" class="footer-logo" src="{{asset('/images/frontend/montivory-logo-negative.svg')}}"></a>
                    <div class="footer-address">
                        {!! html_entity_decode(isset($data->footer)?$data->footer->content:'<p>Montivory Co.,LTD<br>87 M.Thai Tower, Floor 22nd All Seasons Place <br>Wittathayu Road, Lumphini, Pathum Wan Bangkok 10330</p>
                        <p>+66 2 253 0253, +66 2 253 0254<br>
                            Mon- Fri ( 09:00 - 18:00 )<br>
                            info@montivory.com</p>') !!}
                    </div>
                </div>
                <div class="footer-map">
                    {!! html_entity_decode(isset($data->footer)?$data->footer->special:'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.650479157267!2d100.54527511441424!3d13.739598590355348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29fdb139c5503%3A0x37ff8728126e90d7!2sMontivory%20Co.%2CLtd!5e0!3m2!1sen!2sth!4v1655197823040!5m2!1sen!2sth" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>')!!}
                </div>
            </div>
            <div class="footer-bar">
                <div class="footer-social">
                    <a href="https://www.facebook.com/montivory"><i class="ic ic-facebook"></i></a>
                    <a href="https://twitter.com/montivoryth"><i class="ic ic-twitter"></i></a>
                    <a href="https://www.instagram.com/montivory.th"><i class="ic ic-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/montivory"><i class="ic ic-linkedin"></i></a>
                </div>
                <p class="copyright">© 2022 Montivory</p>
            </div>
        </div>
    </div>
</footer>
