    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
        // JavaScript untuk toggle sidebar
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.getElementById('wrapper').classList.toggle('sidebar-hidden');
        });
    </script>


    <script>
        // Fungsi untuk toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('hidden');
            content.classList.toggle('full');
        }
    </script>
</body>
{{-- <footer class="footer" style="background-color: #00a65a;color: #fff;"> --}}
    {{-- <div class="pull-right hidden-xs">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">Powered by KARTANU</marquee> -->
    </div> --}}
    {{-- <b> <i class="fa fa-copyright"></i> Copyright <?php echo date("Y");?></b>. --}}
{{-- </footer> --}}
