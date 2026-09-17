/**
 * main.js - Custom JS for MyTheme
 */
(function($) {
    'use strict';

    $(document).ready(function() {

        // ── Navbar scroll effect ──────────────────────────────
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 50) {
                $('.site-navbar').addClass('scrolled');
            } else {
                $('.site-navbar').removeClass('scrolled');
            }
        });

        // ── Smooth scroll for anchor links ────────────────────
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: target.offset().top - 80 }, 500);
            }
        });

        // ── Search form toggle (mobile) ───────────────────────
        $('#navbar-search-toggle').on('click', function() {
            $('.navbar-search-form').toggleClass('open');
            $('.navbar-search-form input').focus();
        });

        // ── Comment reply ─────────────────────────────────────
        $(document).on('click', '.comment-reply-btn', function() {
            var commentId = $(this).data('comment-id');
            var replyForm = $('#comment-reply-form');
            if (replyForm.length) {
                $('html, body').animate({ scrollTop: replyForm.offset().top - 100 }, 400);
                $('#comment_parent').val(commentId);
                replyForm.find('textarea').focus();
            }
        });

        // ── Animate elements on scroll ────────────────────────
        function animateOnScroll() {
            $('.post-card, .widget-card, .page-post-card').each(function() {
                var elemTop = $(this).offset().top;
                var viewBottom = $(window).scrollTop() + $(window).height();
                if (elemTop < viewBottom - 50) {
                    $(this).addClass('animated');
                }
            });
        }
        $(window).on('scroll', animateOnScroll);
        animateOnScroll();

        // ── Bootstrap tooltip init ────────────────────────────
        $('[data-toggle="tooltip"]').tooltip();

    });

})(jQuery);
