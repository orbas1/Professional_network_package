<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pro_network_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('connection_id')->constrained('users');
            $table->unsignedTinyInteger('degree')->default(1);
            $table->json('mutuals')->nullable();
            $table->timestamps();
            $table->unique(['user_id','connection_id']);
        });

        Schema::create('pro_network_professional_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->unique();
            $table->string('headline')->nullable();
            $table->string('location')->nullable();
            $table->json('top_skills')->nullable();
            $table->json('skills')->nullable();
            $table->json('certifications')->nullable();
            $table->json('work_history')->nullable();
            $table->json('education')->nullable();
            $table->json('references')->nullable();
            $table->json('dbs')->nullable();
            $table->json('gigs')->nullable();
            $table->json('projects')->nullable();
            $table->json('jobs')->nullable();
            $table->boolean('available_for_work')->default(false);
            $table->string('public_url')->nullable()->unique();
            $table->unsignedInteger('connections_count')->default(0);
            $table->json('interests')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages');
            $table->string('headline')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedInteger('employee_count')->default(0);
            $table->timestamps();
        });

        Schema::create('pro_network_marketplace_escrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('marketplace_orders');
            $table->enum('status', ['pending','held','released','refunded','disputed'])->default('pending');
            $table->decimal('amount', 12, 2);
            $table->enum('delivery_type', ['delivery','collection'])->default('delivery');
            $table->timestamp('held_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_marketplace_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escrow_id')->constrained('pro_network_marketplace_escrows');
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending','submitted','approved','rejected'])->default('pending');
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_marketplace_disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escrow_id')->constrained('pro_network_marketplace_escrows');
            $table->foreignId('raised_by')->constrained('users');
            $table->text('reason');
            $table->enum('status', ['open','under_review','resolved','refunded','rejected'])->default('open');
            $table->timestamps();
        });

        Schema::create('pro_network_story_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories');
            $table->json('guests')->nullable();
            $table->json('music')->nullable();
            $table->json('links')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_live_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->json('guests')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('donations')->default(0);
            $table->boolean('record_to_story')->default(false);
            $table->timestamps();
        });

        Schema::create('pro_network_reactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('reactable');
            $table->foreignId('user_id')->constrained('users');
            $table->string('type');
            $table->timestamps();
            $table->unique(['reactable_id','reactable_type','user_id']);
        });

        Schema::create('pro_network_reaction_aggregates', function (Blueprint $table) {
            $table->id();
            $table->morphs('reactable');
            $table->integer('score')->default(0);
            $table->integer('dislikes')->default(0);
            $table->timestamps();
        });

        Schema::create('pro_network_hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->unique();
            $table->timestamps();
        });

        Schema::create('pro_network_hashtaggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hashtag_id')->constrained('pro_network_hashtags');
            $table->morphs('hashtaggable');
            $table->timestamps();
            $table->unique(['hashtag_id','hashtaggable_id','hashtaggable_type'], 'hashtaggable_unique');
        });

        Schema::create('pro_network_music_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('url');
            $table->string('license')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_security_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('ip')->nullable();
            $table->string('event');
            $table->json('context')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_moderation_queue', function (Blueprint $table) {
            $table->id();
            $table->morphs('moderatable');
            $table->string('reason');
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->json('flags')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_bad_words', function (Blueprint $table) {
            $table->id();
            $table->string('phrase')->unique();
            $table->timestamps();
        });

        Schema::create('pro_network_file_scans', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->enum('status', ['pending','clean','infected','error'])->default('pending');
            $table->json('details')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->json('properties')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('features')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_user_account_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('account_type_id')->constrained('pro_network_account_types');
            $table->timestamps();
            $table->unique(['user_id','account_type_id']);
        });

        Schema::create('pro_network_age_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->unique();
            $table->enum('status', ['pending','verified','rejected'])->default('pending');
            $table->string('provider_reference')->nullable();
            $table->timestamps();
        });

        Schema::create('pro_network_newsletter_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('email');
            $table->boolean('subscribed')->default(true);
            $table->timestamps();
            $table->unique('email');
        });

        Schema::create('pro_network_invite_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('post_id')->nullable()->constrained('posts');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pro_network_invite_contributions');
        Schema::dropIfExists('pro_network_newsletter_subscriptions');
        Schema::dropIfExists('pro_network_age_verifications');
        Schema::dropIfExists('pro_network_user_account_types');
        Schema::dropIfExists('pro_network_account_types');
        Schema::dropIfExists('pro_network_analytics_events');
        Schema::dropIfExists('pro_network_file_scans');
        Schema::dropIfExists('pro_network_bad_words');
        Schema::dropIfExists('pro_network_moderation_queue');
        Schema::dropIfExists('pro_network_security_events');
        Schema::dropIfExists('pro_network_music_tracks');
        Schema::dropIfExists('pro_network_hashtaggables');
        Schema::dropIfExists('pro_network_hashtags');
        Schema::dropIfExists('pro_network_reaction_aggregates');
        Schema::dropIfExists('pro_network_reactions');
        Schema::dropIfExists('pro_network_live_sessions');
        Schema::dropIfExists('pro_network_story_metadata');
        Schema::dropIfExists('pro_network_marketplace_disputes');
        Schema::dropIfExists('pro_network_marketplace_milestones');
        Schema::dropIfExists('pro_network_marketplace_escrows');
        Schema::dropIfExists('pro_network_company_profiles');
        Schema::dropIfExists('pro_network_professional_profiles');
        Schema::dropIfExists('pro_network_connections');
    }
};
