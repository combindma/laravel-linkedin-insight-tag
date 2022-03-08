@if($enabled)
@unless(empty($conversionLayer->toArray()))
<!-- Linkedin Insight Tag Conversions -->
<script>
@foreach($conversionLayer->toArray() as $conversionId)
    window.lintrk('track', { conversion_id: {{ $conversionId }} });
@endforeach
</script>
<!-- End Linkedin Insight Tag Conversions -->
@endunless
@endif
